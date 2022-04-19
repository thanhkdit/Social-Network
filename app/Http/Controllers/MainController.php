<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
use App\Models\Relationship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserNotifications;

class MainController extends Controller
{
    public static function get_friend($user_id, $online = false, $relationship = [], $filterRelationship = ''){
        //TODO: pro SQL
        // SELECT IF (user_first = 2, user_second, user_first) as friend, name, status_online FROM `relationships` JOIN `users` on IF (relationships.user_first = 2, relationships.user_second = users.id, relationships.user_first = users.id)  WHERE user_first = 2 or user_second = 2;

        // DB::enableQueryLog(); // Enable query log
        $user = DB::table('users')->join('relationships',function($join) use($user_id){
                $join->on('users.id','=',DB::raw("IF (relationships.user_first = $user_id, relationships.user_second, relationships.user_first)"));
            })
            ->select('users.*', 'user_first', 'user_second', 'type_id', DB::raw("IF (relationships.user_first = $user_id, user_second, user_first) as friend_id"))
            ->where('users.email_verified_at', '<>', null)
            ->where(function($query) use($user_id){
                $query->where('relationships.user_first',$user_id)
                    ->orWhere('relationships.user_second',$user_id);
            });
        if ($online == true) {
            $user = $user->where('users.status_online', config('status.online'));
        }
        if (!empty($relationship)) {
            $user = $user->whereIn('relationships.type_id', $relationship);
        }
        if ($filterRelationship == config('status.follow_me')) {
            $user = $user
            ->where(function($query) use ($user_id) {
                $query->whereRaw("relationships.type_id = IF (relationships.user_first = $user_id, " . config('status.pending_second_first') . ", " . config('status.pending_first_second') . ")")
                    ->orWhere('relationships.type_id', config('status.friends'));
            });
        }
        $user = $user->get();
        return $user;
    }

    public static function get_earlier_messages($user_id, $all=false){
        $userId = auth()->user()->id;
        $participants = DB::table('participants')->join('room_chat','participants.room_code','room_chat.room_code')->join('messages','room_chat.room_code','messages.room_code')->selectRaw('participants.room_code, status_seen, max(time) as max_time, participants.user_id as p_user_id')->where('participants.user_id',$user_id)->groupByRaw('participants.room_code, participants.status_seen, participants.user_id')->orderBy('max_time','desc')->get();

        $list_room_code = array();
        $list_status_seen = array();
        if (!$all) {
            define('NUMS_OF_EARLIER_MESSAGES',100);
        }
        $nums_messages_unseen = 0; // Số tin nhắn chưa xem trong NUMS_OF_EARLIER_MESSAGES cuộc trò chuyện gần đây
        $i = 0; // Bien dem
        foreach($participants as $row){
            $list_room_code[] = $row->room_code;
            $list_status_seen[] = $row->status_seen==0?'unseen':'';
            if ($i <= NUMS_OF_EARLIER_MESSAGES && $row->status_seen == 0){
                $nums_messages_unseen++;
            }
            $i++;
        }

        //* Rooms, Messages
        $list_rooms = array();
        $list_messages = array();
        foreach($list_room_code as $room_code){
            $messages = DB::table('messages')->join('room_chat','room_chat.room_code','messages.room_code')->join('users','users.id','messages.user_id')->where('room_chat.room_code',$room_code)->orderBy('time','desc')->first();
            $list_messages[] = $messages;

            $list_rooms[] = DB::table('room_chat')->join('participants','participants.room_code','room_chat.room_code')->join('users','users.id','participants.user_id')->where('room_chat.room_code',$room_code)->where('participants.user_id','!=',$user_id)->first();
        }
        
        $data = array();
        $data['list_messages'] = $list_messages;
        $data['list_rooms'] = $list_rooms;
        $data['list_status_seen'] = $list_status_seen;
        $data['nums_messages_unseen'] = $nums_messages_unseen;
        return $data;
    }

    public static function get_room_code($user_first, $user_second){
        $room_code = $user_first < $user_second ? $user_first.'-'.$user_second : $user_second.'-'.$user_first;
        return $room_code;
    }

    public static function getCalendar($user_id){
        $user = User::with('calendars')->find($user_id);
        return $user->calendars()->orderBy('created_at', 'desc')->get();
    }

    public static function getPost($newPost = 0, $filter=0)
    {
        $userId = auth()->user()->id;
        if ($filter == 0) {
            $posts = Post::with('postUsers', 'images', 'user', 'comments.images', 'comments.replies.images' ,'comments.replies.user', 'comments.user', 'tagUsers')
                            ->whereHas('postUsers', function($query) use ($userId) {
                                $query->where('user_posts.user_id', $userId)
                                    ->where(function($query1) {
                                        $query1->where('option', config('status.follow_post'))
                                            ->orWhere('option', config('status.save_and_follow_post'))
                                            ->orWhere('option', config('status.notify_post'))
                                            ->orWhere('option', config('status.save_and_notify_post'))
                                            ->orWhere('option', config('status.no_notify_post'));
                                    });
                            })
                            ->where('type', '<>', config('status.private'))
                            ->latest()->get();
        } else if ($filter == 1) {
            $friends = self::getFriends(auth()->user()->id)->pluck('id')->toArray();
            $posts = Post::with('postUsers', 'images', 'user', 'comments.images', 'comments.replies.images' ,'comments.replies.user', 'comments.user', 'tagUsers')
                        ->whereIn('author', $friends)
                        ->where('type', '<>', config('status.private'))
                        ->latest()->get();
        } else if ($filter == 2) {
            $posts = Post::with('postUsers', 'images', 'user', 'comments.images', 'comments.replies.images' ,'comments.replies.user', 'comments.user', 'tagUsers')
                            ->whereHas('postUsers', function($query) use ($userId) {
                                $query->where('user_posts.user_id', $userId)
                                    ->where(function($query1) {
                                        $query1->where('option', config('status.follow_post'))
                                            ->orWhere('option', config('status.save_and_follow_post'))
                                            ->orWhere('option', config('status.notify_post'))
                                            ->orWhere('option', config('status.save_and_notify_post'))
                                            ->orWhere('option', config('status.no_notify_post'));
                                    });
                            })->whereHas('images', function($query) {
                                $query->where('type', config('status.video'));
                            })
                            ->where('type', '<>', config('status.private'))
                            ->latest()->get();
        }
        if ($newPost == 1) {
            $myNewPost = Post::with('postUsers', 'images', 'user', 'comments')->where('author', $userId)->latest()->first();
            if ($myNewPost) {
                $posts = $posts->prepend($myNewPost);
            }
        }

        return $posts;
    }

    public static function getMyPost()
    {
        $userId = auth()->user()->id;
        $posts = Post::with('postUsers', 'images', 'user', 'comments.images', 'comments.replies.images' ,'comments.replies.user', 'comments.user', 'tagUsers')
                        ->where('author', $userId)
                        ->latest()->get();

        return $posts;
    }

    public static function getSavedPost()
    {
        $userId = auth()->user()->id;
        $posts = Post::with('postUsers', 'images', 'user', 'comments', 'tagUsers')
                        ->whereHas('postUsers', function($query) use ($userId) {
                            $query->where('user_posts.user_id', $userId)
                            ->where(function($query1) {
                                $query1->where('option', config('status.save_post'))
                                    ->orWhere('option', config('status.save_and_follow_post'))
                                    ->orWhere('option', config('status.save_and_notify_post'));
                            });
                        })
                        ->latest()->get();

        return $posts;
    }

    public static function getHidePost()
    {
        $userId = auth()->user()->id;
        $posts = Post::with('postUsers', 'images', 'user', 'comments', 'tagUsers')
                        ->whereHas('postUsers', function($query) use ($userId) {
                            $query->where('user_posts.user_id', $userId)
                                ->where('option', config('status.hide_post'));
                        })
                        ->latest()->get();

        return $posts;
    }

    public static function getNotifications()
    {
        $notifications = auth()->user()->userNotifications()->with('notification')->latest()->get();

        return $notifications;
    }

    public static function getFriends($userId, $limit=0)
    {
        $friend1 = Relationship::where('user_first', $userId)
                    ->where('type_id', config('status.friends'))
                    ->get()->pluck('user_second')->toArray();
        $friend2 = Relationship::where('user_second', $userId)
                    ->where('type_id', config('status.friends'))
                    ->get()->pluck('user_first')->toArray();
        $friends = array_merge($friend1, $friend2);
        if ($limit > 0) {
            $friends = User::whereIn('id', $friends)->latest()->offset(0)->limit($limit)->get();
        } else {
            $friends = User::whereIn('id', $friends)->latest()->get();
        }

        return $friends;
    }

    public static function getRequests($userId, $limit=0)
    {
        $friend1 = Relationship::where('user_first', $userId)
                    ->where('type_id', config('status.pending_second_first'))
                    ->get()->pluck('user_second')->toArray();
        $friend2 = Relationship::where('user_second', $userId)
                    ->where('type_id', config('status.pending_first_second'))
                    ->get()->pluck('user_first')->toArray();
        $friends = array_merge($friend1, $friend2);
        if ($limit > 0) {
            $friends = User::whereIn('id', $friends)->latest()->offset(0)->limit($limit)->get();
        } else {
            $friends = User::whereIn('id', $friends)->latest()->get();
        }

        return $friends;
    }

    public static function getNumsFriend($userId)
    {
        $nums_friends = Relationship::where(function($query) use ($userId) {
                        $query->where('user_first', $userId)
                            ->orWhere('user_second', $userId);
                    })
                    ->where('type_id', config('status.friends'))
                    ->count();

        return $nums_friends;
    }

    public static function getImages($userId, $limit=0, $video=0)
    {
        $posts = Post::with('images')->where('author', $userId)->latest()->get()->pluck('id')->toArray();
        if ($limit == 0) {
            if ($video == 1) {
                $images = Image::whereIn('post_id', $posts)->get();
            } else {
                $images = Image::whereIn('post_id', $posts)->where('type', config('status.image'))->get();
            }
        } else {
            $images = Image::whereIn('post_id', $posts)->where('type', config('status.image'))->offset(0)->limit($limit)->get();
        }
        
        return $images;
    }

    public static function getUserPost($userId)
    {
        $posts = Post::with('postUsers', 'images', 'user', 'comments.images', 'comments.replies.images' ,'comments.replies.user', 'comments.user', 'tagUsers')
                        ->where('author', $userId)->where('type', config('status.public'))
                        ->latest()->get();

        return $posts;
    }

    public static function getRelationship($userId, $friendId)
    {
        $relation = Relationship::where('user_first', $userId)
                    ->where('user_second', $friendId)
                    ->first();
        if ($relation) {
            if ($relation->type_id == config('status.friends')) {
                return config('status.friends');
            } else if ($relation->type_id == config('status.pending_first_second')) {
                return config('status.i_request');
            } else if ($relation->type_id == config('status.pending_second_first')) {
                return config('status.request_me');
            }
        }
        else {
            $relation = Relationship::where('user_first', $friendId)
                        ->where('user_second', $userId)
                        ->first();
            if ($relation) {
                if ($relation->type_id == config('status.friends')) {
                    return config('status.friends');
                } else if ($relation->type_id == config('status.pending_first_second')) {
                    return config('status.request_me');
                } else if ($relation->type_id == config('status.pending_second_first')) {
                    return config('status.i_request');
                }
            }
        }
        
        return config('status.no_relationship');
    }
}
