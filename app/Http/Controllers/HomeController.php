<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Relationship;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function get_news_feed(Request $request){
        $data['user_online'] = MainController::get_friend(auth()->user()->id, true);
        $data['friends'] = MainController::get_friend(auth()->user()->id, false, [config('status.friends')]);
        $data['earlier_messages'] = MainController::get_earlier_messages(auth()->user()->id);
        $data['calendars'] = MainController::getCalendar(auth()->user()->id);
        $data['notifications'] = MainController::getNotifications();
        if ($request->saved == 1) {
            $data['posts'] = MainController::getSavedPost();
        } else if ($request->hide == 1) {
            $data['posts'] = MainController::getHidePost();
        } else if ($request->filter == 2) { // video
            $data['posts'] = MainController::getPost(0, 2);
            $data['active_filter'] = 2;
        } else if ($request->filter == 1) { // friend
            $data['posts'] = MainController::getPost(0, 1);
            $data['active_filter'] = 3;
        } else {
            $data['posts'] = MainController::getPost($request->new_post);
            $data['active_filter'] = 1;
        }
        
        return view('news_feed', $data);
    }

    public function getPersonalPage(Request $request)
    {
        $data['user_online'] = MainController::get_friend(auth()->user()->id, true);
        $data['friends'] = MainController::get_friend(auth()->user()->id, false, [config('status.friends')]);
        $data['earlier_messages'] = MainController::get_earlier_messages(auth()->user()->id);
        $data['calendars'] = MainController::getCalendar(auth()->user()->id);
        $data['notifications'] = MainController::getNotifications();
        $data['posts'] = MainController::getMyPost();
        $data['nums_friend'] = MainController::getNumsFriend(auth()->user()->id);
        $data['data_friends'] = MainController::getFriends(auth()->user()->id, 6);
        $data['user_images'] = MainController::getImages(auth()->user()->id, 6);
        $data['data_user'] = User::with('userPosts')->find(auth()->user()->id);
        $data['relation'] = '';
        
        return view('personal', $data);
    }

    public function getPersonalFriends(Request $request)
    {
        $data['user_online'] = MainController::get_friend(auth()->user()->id, true);
        $data['friends'] = MainController::get_friend(auth()->user()->id, false, [config('status.friends')]);
        $data['earlier_messages'] = MainController::get_earlier_messages(auth()->user()->id);
        $data['calendars'] = MainController::getCalendar(auth()->user()->id);
        $data['notifications'] = MainController::getNotifications();
        $data['nums_friend'] = MainController::getNumsFriend(auth()->user()->id);
        $data['data_friends'] = MainController::getFriends(auth()->user()->id, 6);
        $data['data_all_friends'] = MainController::getFriends(auth()->user()->id);
        $data['user_images'] = MainController::getImages(auth()->user()->id, 6);
        $data['data_user'] = User::with('userPosts')->find(auth()->user()->id);
        
        return view('user_friends', $data);
    }

    public function getPersonalRequests(Request $request)
    {
        $data['user_online'] = MainController::get_friend(auth()->user()->id, true);
        $data['friends'] = MainController::get_friend(auth()->user()->id, false, [config('status.friends')]);
        $data['earlier_messages'] = MainController::get_earlier_messages(auth()->user()->id);
        $data['calendars'] = MainController::getCalendar(auth()->user()->id);
        $data['notifications'] = MainController::getNotifications();
        $data['nums_friend'] = MainController::getNumsFriend(auth()->user()->id);
        $data['data_friends'] = MainController::getFriends(auth()->user()->id, 6);
        $data['data_requests'] = MainController::getRequests(auth()->user()->id, 6);
        $data['user_images'] = MainController::getImages(auth()->user()->id, 6);
        $data['data_user'] = User::with('userPosts')->find(auth()->user()->id);
        
        return view('user_requests', $data);
    }

    public function getPersonalImages(Request $request)
    {
        $data['user_online'] = MainController::get_friend(auth()->user()->id, true);
        $data['friends'] = MainController::get_friend(auth()->user()->id, false, [config('status.friends')]);
        $data['earlier_messages'] = MainController::get_earlier_messages(auth()->user()->id);
        $data['calendars'] = MainController::getCalendar(auth()->user()->id);
        $data['notifications'] = MainController::getNotifications();
        $data['nums_friend'] = MainController::getNumsFriend(auth()->user()->id);
        $data['data_friends'] = MainController::getFriends(auth()->user()->id, 6);
        $data['data_all_images'] = MainController::getImages(auth()->user()->id, 0, 1);
        $data['user_images'] = MainController::getImages(auth()->user()->id, 6);
        $data['data_user'] = User::with('userPosts')->find(auth()->user()->id);
        
        return view('user_images', $data);
    }

    public function getUserPage($userId)
    {
        if ($userId == auth()->user()->id) {
            return redirect()->route('personal.page');
        }
        $data['user_online'] = MainController::get_friend(auth()->user()->id, true);
        $data['friends'] = MainController::get_friend(auth()->user()->id, false, [config('status.friends')]);
        $data['earlier_messages'] = MainController::get_earlier_messages(auth()->user()->id);
        $data['calendars'] = MainController::getCalendar(auth()->user()->id);
        $data['notifications'] = MainController::getNotifications();
        $data['posts'] = MainController::getUserPost($userId);
        $data['nums_friend'] = MainController::getNumsFriend($userId);
        $data['data_friends'] = MainController::getFriends($userId, 6);
        $data['user_images'] = MainController::getImages($userId, 6);
        $data['data_user'] = User::with('userPosts')->find($userId);
        $data['relation'] = MainController::getRelationship(auth()->user()->id, $userId);

        return view('personal', $data);
    }

    public function getUserFriends($userId)
    {
        $data['user_online'] = MainController::get_friend(auth()->user()->id, true);
        $data['friends'] = MainController::get_friend(auth()->user()->id, false, [config('status.friends')]);
        $data['earlier_messages'] = MainController::get_earlier_messages(auth()->user()->id);
        $data['calendars'] = MainController::getCalendar(auth()->user()->id);
        $data['notifications'] = MainController::getNotifications();
        $data['nums_friend'] = MainController::getNumsFriend($userId);
        $data['data_friends'] = MainController::getFriends($userId, 6);
        $data['data_all_friends'] = MainController::getFriends($userId);
        $data['data_user'] = User::with('userPosts')->find($userId);
        $data['user_images'] = MainController::getImages($userId, 6);
        $data['relation'] = MainController::getRelationship(auth()->user()->id, $userId);
        
        return view('user_friends', $data);
    }

    public function getUserImages($userId)
    {
        $data['user_online'] = MainController::get_friend(auth()->user()->id, true);
        $data['friends'] = MainController::get_friend(auth()->user()->id, false, [config('status.friends')]);
        $data['earlier_messages'] = MainController::get_earlier_messages(auth()->user()->id);
        $data['calendars'] = MainController::getCalendar(auth()->user()->id);
        $data['notifications'] = MainController::getNotifications();
        $data['nums_friend'] = MainController::getNumsFriend($userId);
        $data['data_friends'] = MainController::getFriends($userId, 6);
        $data['data_all_images'] = MainController::getImages($userId, 0, 1); // limit: 0, video: 1 (get image and video)
        $data['data_user'] = User::with('userPosts')->find($userId);
        $data['user_images'] = MainController::getImages($userId, 6);
        $data['relation'] = MainController::getRelationship(auth()->user()->id, $userId);
        
        return view('user_images', $data);
    }

    public function getProfile()
    {
        $data['friends'] = MainController::get_friend(auth()->user()->id, false, [config('status.friends')]);
        $data['earlier_messages'] = MainController::get_earlier_messages(auth()->user()->id);
        $data['notifications'] = MainController::getNotifications();
        
        return view('profile', $data);
    }
}
