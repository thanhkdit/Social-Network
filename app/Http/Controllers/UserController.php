<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Notification;
use App\Models\Participant;
use App\Models\Post;
use App\Models\Relationship;
use App\Models\User;
use App\Models\UserPost;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function update_user_status_online(Request $request){
        $user_id = $request->user_id;
        DB::table('users')->where('id',$user_id)->update(['status_online'=>1]);
        $user = DB::table('users')->where('id',$user_id)->first();
        return $user;
    }
    
    public function update_user_status_offline(Request $request){
        $user_id = $request->user_id;
        DB::table('users')->where('id',$user_id)->update(['status_online'=>0]);
        return $user_id;
    }

    public function updateRequest(Request $request)
    {
        $userId = auth()->user()->id;
        $status = $request->status;
        if ($status == 1) {
            $update = Relationship::where(function($query) use ($request){
                $query->where('user_first', $request->user_id)
                    ->where('user_second', $request->friend_id);
            })->orWhere(function($query) use ($request) {
                $query->where('user_second', $request->user_id)
                    ->where('user_first', $request->friend_id);
            })->update(['type_id' => config('status.friends')]);
            $notification = Notification::create([
                'title' => 'Aceppt request friend',
                'content' => '<small>' . User::find($request->user_id)->name . '</small> has accepted your friend request',
                'link' => config('status.base_url') . "/other-personal/$request->user_id",
                'image' => auth()->user()->avatar
            ]);
            $notification->users()->attach($request->friend_id, ['status' => config('status.unseen')]);

            $friendPosts = Post::where('author', $request->friend_id)->get()->pluck('id')->toArray();
            $pivotData = array_fill(0, count($friendPosts), ['option' => config('status.follow_post')]);
            $syncData  = array_combine($friendPosts, $pivotData);
            $sync = User::with('userPosts')->find($userId)->userPosts()->sync($syncData, false);

            $userPosts = Post::where('author', $userId)->get()->pluck('id')->toArray();
            $pivotData = array_fill(0, count($userPosts), ['option' => config('status.follow_post')]);
            $syncData  = array_combine($userPosts, $pivotData);
            $sync = User::with('userPosts')->find($request->friend_id)->userPosts()->sync($syncData, false);
        } else if ($status == 0) { // tu choi ket ban
            $update = Relationship::where(function($query) use ($request) {
                $query->where('user_first', $request->user_id)
                    ->where('user_second', $request->friend_id);
            })->orWhere(function($query) use ($request) {
                $query->where('user_second', $request->user_id)
                    ->where('user_first', $request->friend_id);
            })->delete();
            $notification = Notification::create([
                'title' => 'Reject request friend',
                'content' => '<small>' . User::find($request->user_id)->name . '</small> has rejected your friend request',
                'link' => config('status.base_url') . "/other-personal/$request->user_id",
                'image' => auth()->user()->avatar
            ]);
            $notification->users()->attach($request->friend_id, ['status' => config('status.unseen')]);
        } else if ($status == -1) { // huy ket ban
            $update = Relationship::where(function($query) use ($request) {
                $query->where('user_first', $request->user_id)
                    ->where('user_second', $request->friend_id);
            })->orWhere(function($query) use ($request) {
                $query->where('user_second', $request->user_id)
                    ->where('user_first', $request->friend_id);
            })->delete();
            $notification = [];

            $friendPosts = Post::where('author', $request->friend_id)->get()->pluck('id')->toArray();
            $delete = UserPost::whereIn('post_id', $friendPosts)->where('user_id', $userId)
                                ->where('option', config('status.follow_post'))
                                ->delete();
            $update = UserPost::whereIn('post_id', $friendPosts)->where('user_id', $userId)
                                ->where('option', config('status.save_and_follow_post'))
                                ->update([
                                    'option' => config('status.save_post')
                                ]);

            $userPosts = Post::where('author', $userId)->get()->pluck('id')->toArray();
            $delete = UserPost::whereIn('post_id', $userPosts)->where('user_id', $request->friend_id)
                                ->where('option', config('status.follow_post'))
                                ->delete();
            $update = UserPost::whereIn('post_id', $userPosts)->where('user_id', $request->friend_id)
                                ->where('option', config('status.save_and_follow_post'))
                                ->update([
                                    'option' => config('status.save_post')
                                ]);
            
        } else {
            if ($request->user_id > $request->friend_id) {
                $user_first = $request->friend_id;
                $user_second = $request->user_id;
            } else {
                $user_first = $request->user_id;
                $user_second = $request->friend_id;
            }

            $create = Relationship::create([
                'user_first' => $user_first,
                'user_second' => $user_second,
                'type_id' => $status
            ]);

            $notification = Notification::create([
                'title' => 'Send request friend',
                'content' => '<small>' . User::find($request->user_id)->name . '</small> sent a friend request',
                'link' => config('status.base_url') . "/other-personal/$request->user_id",
                'image' => auth()->user()->avatar
            ]);
            $notification->users()->attach($request->friend_id, ['status' => config('status.unseen')]);
        }

        return response()->json(['data' => $status, 'user_receive' => $request->friend_id, 'user_avatar' => auth()->user()->avatar, 'notification' => $notification]);
    }

    public function updateProfile(UpdateUserRequest $request)
    {
        $data = $request->only('name', 'description', 'phone', 'birthday', 'address', 'introduce');

        if ($request->hasFile('avatar')) {
            $uploadedFile = $request->file('avatar');
            $path = $uploadedFile->storeAs('avatar', 'avatar' . Carbon::now()->timestamp . '.' . $uploadedFile->getClientOriginalExtension(), 'public');
            $url = Storage::disk('public')->url($path);
            if (config('status.port')) {
                $url = str_replace('localhost', 'localhost:' . config('status.port'), $url);
            }
            $data['avatar'] = $url;
        }
        $update = User::find(auth()->user()->id)->update($data);
        return back();
    }

    public function search(Request $request) {
        $value = $request->value;
        $dataUser = User::where('name', 'like', "%$value%")->where('id', '<>', auth()->user()->id)->get();

        return response()->json(['data' => $dataUser]);
    }

    public function searchUserMessage(Request $request) {
        $value = $request->value;
        $participants = Participant::where('user_id', auth()->user()->id)->get()->pluck('room_code')->toArray();
        $arrayUser = Participant::whereIn('room_code', $participants)->where('user_id', '<>', auth()->user()->id)->get()->pluck('user_id')->toArray();
        $data = User::whereIn('id', $arrayUser)->where('name', 'like', "%$value%")->get();

        return response()->json(['data' => $data]);
    }
}
