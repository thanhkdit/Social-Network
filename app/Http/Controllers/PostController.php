<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Reply;
use App\Models\Image;
use App\Models\Notification;
use App\Models\UserNotifications;
use App\Models\Post;
use App\Models\Tag;
use App\Models\UserPost;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function show($id)
    {
        $data['user_online'] = MainController::get_friend(auth()->user()->id, true);
        $data['friends'] = MainController::get_friend(auth()->user()->id, false, [config('status.friends')]);
        $data['earlier_messages'] = MainController::get_earlier_messages(auth()->user()->id);
        $data['calendars'] = MainController::getCalendar(auth()->user()->id);
        $data['notifications'] = MainController::getNotifications();
        $post = Post::find($id);
        if ($post) {
            if ($post->author == auth()->user()->id) {
                $data['posts'] = Post::with('postUsers', 'images', 'user', 'comments.images', 'comments.replies.images' ,'comments.replies.user', 'comments.user', 'tagUsers')
                                    ->find($id);
            } else {
                $data['posts'] = Post::with('postUsers', 'images', 'user', 'comments.images', 'comments.replies.images' ,'comments.replies.user', 'comments.user', 'tagUsers')
                                    ->where('id', $id)
                                    ->where('type', '<>', config('status.private'))
                                    ->first();
            }
        } else {
            $data['posts'] = [];
            return view('news_feed', $data);
        }
        if (!$data['posts']) {
            $data['posts'] = [];
            return view('news_feed', $data);
        }
        $data['posts'] = [$data['posts']];
        return view('news_feed', $data);
    }

    public function store(Request $request)
    {
        $userId = auth()->user()->id;
        $data = $request->all();
        $data['time'] = Carbon::now();
        $data['author'] = auth()->user()->id;
        $post = Post::create($data);
        $postId = $post->id;

        // Add image post
        $files = $request->file('f_media');
        if (!empty($files)) {
            foreach($files as $index => $file) {
                if ($file) {
                    $mime = $file->getMimeType();
                    if (strstr($mime, "video/")){
                        $type = config('status.video');
                    } else if(strstr($mime, "image/")){
                        $type = config('status.image');
                    }
                    $path = $file->storeAs('post-images', "post$index-" . $data['time']->timestamp . '.' . $file->getClientOriginalExtension(), 'public');

                    $url = Storage::disk('public')->url($path);
                    if (config('status.port')) {
                        $url = str_replace('localhost', 'localhost:' . config('status.port'), $url);
                    }
                    Image::create([
                        'name' => "post$index-" . $data['time']->timestamp . '.' . $file->getClientOriginalExtension(),
                        'url' => $url,
                        'type' => $type,
                        'post_id' => $post->id
                    ]);
                }
            }
        }
        // Add tags
        if (!empty($data['tags'])) {
            Tag::create([
                'user_id' => $data['tags'],
                'post_id' => $post->id
            ]);
            $notificationTag = Notification::create([
                'title' => 'Tag post',
                'content' => '<small>' . auth()->user()->name . '</small> tagged you in a post',
                'link' => config('status.base_url') . "/post/$postId",
                'image' => auth()->user()->avatar
            ]);
            $notificationTag->users()->attach($data['tags'], ['status' => config('status.unseen')]);
        }

        $userReceiveNotify = [];
        if ($post->type == config('status.public')) {
            $userReceiveNotify = MainController::get_friend($userId, false, [], config('status.follow_me'))->pluck('id')->toArray();
        } else if ($post->type == config('status.only_friend')) {
            $userReceiveNotify = MainController::get_friend($userId, false, [config('status.friends')])->pluck('id')->toArray();
        }
        if (!empty($userReceiveNotify)) {
            $post->postUsers()->attach($userReceiveNotify, ['option' => config('status.follow_post')]);
            $post->postUsers()->attach($userId, ['option' => config('status.created_post')]);
            $notification = Notification::create([
                'title' => 'Create post',
                'content' => '<small>' . auth()->user()->name . '</small> created a new post',
                'link' => config('status.base_url') . "/post/$postId",
                'image' => auth()->user()->avatar
            ]);
            $notification->users()->attach($userReceiveNotify, ['status' => config('status.unseen')]);
        }
        if (isset($notificationTag)) {
            return response()->json([
                'notification' => $notification,
                'notification_tag' => $notificationTag,
                'user_tag' => $data['tags'],
                'user_receive' => $userReceiveNotify,
                'user_avatar' => auth()->user()->avatar
            ]);
        }

        return response()->json([
            'notification' => $notification,
            'user_receive' => $userReceiveNotify,
            'user_avatar' => auth()->user()->avatar
        ]);
    }

    public function delete(Request $request) {
        $delete = Post::where('id', $request->post_id)->where('author', auth()->user()->id)->delete();

        return response()->json(['data' => $delete]);
    }

    public function likePost(Request $request) {
        $userLike = auth()->user()->id;
        $postId = $request->post_id;
        $post = Post::with('postUsers')->find($postId);
        $postUser = Post::with('postUsers')
                        ->whereHas('postUsers', function($query) use ($userLike, $postId) {
                            $query->where('user_posts.user_id', $userLike)->where('post_id', $postId);
                        })
                        ->first();
        if (empty($postUser)) {
            Post::with('postUsers')->find($postId)->postUsers()->attach($userLike, ['option' => config('status.reaction_post'), 'reaction' => config('status.no_reaction')]);
        }
        $postUser = Post::with('postUsers')
                        ->whereHas('postUsers', function($query) use ($userLike, $postId) {
                            $query->where('user_posts.user_id', $userLike)->where('post_id', $postId);
                        })
                        ->first();
        $isLike = $post->postUsers->find($userLike)->pivot->reaction;
        if ($isLike != config('status.no_reaction')) {
            $post->postUsers()->updateExistingPivot($userLike, ['reaction' => 0], false);
            $updatePost = $post->update(['nums_like' => $post->nums_like - 1]);
        } else {
            $post->postUsers()->updateExistingPivot($userLike, ['reaction' => 1], false);
            $updatePost = $post->update(['nums_like' => $post->nums_like + 1]);
            if (auth()->user()->id != $post->author) {
                $notification = Notification::where(
                    ['title' => 'Like post', 'content' => '<small>' . auth()->user()->name . '</small> like your post', 'link' => config('status.base_url') . "/post/$postId"],
                )->first();
                if (empty($notification)) {
                    $notification = Notification::create([
                        'title' => 'Like post',
                        'content' => '<small>' . auth()->user()->name . '</small> like your post',
                        'link' => config('status.base_url') . "/post/$postId",
                        'image' => auth()->user()->avatar,
                    ]);
                    $notification->users()->attach($post->author, ['status' => config('status.unseen')]);

                    return response()->json(['nums_like' => $post->nums_like, 'notification' => $notification, 'user_receive' => $post->author, 'user_avatar' => auth()->user()->avatar]);
                }
            }
        }

        return response()->json(['nums_like' => $post->nums_like]);
    }

    public function likeComment(Request $request) {
        $commentId = $request->comment_id;
        $comment = Comment::find($commentId);
        $comment->update(['nums_like' => $comment->nums_like + 1]);

        return response()->json(['nums_like' => $comment->nums_like]);
    }

    public function likeReply(Request $request) {
        $replyId = $request->reply_id;
        $reply = Reply::find($replyId);
        $reply->update(['nums_like' => $reply->nums_like + 1]);

        return response()->json(['nums_like' => $reply->nums_like]);
    }

    public function changeOption(Request $request) {
        $optionId = $request->option_id;
        $postId = $request->post_id;
        $userId = auth()->user()->id;
        if ($optionId == config('status.follow_post')) {
            $userPost = UserPost::where('post_id', $postId)
                        ->where('user_id', $userId)
                        ->where('option', config('status.save_post'))
                        ->first();
            if ($userPost) {
                $userPost = $userPost->update(['option' => config('status.save_and_follow_post')]);
            } else {
                $userPost = UserPost::updateOrCreate(
                    ['post_id' => $postId, 'user_id' => $userId],
                    ['post_id' => $postId, 'user_id' => $userId, 'option' => config('status.follow_post')]
                );
            }
        } else if ($optionId == config('status.unfollow_post')) {
            $userPost = UserPost::where('post_id', $postId)
                        ->where('user_id', $userId)
                        ->where('option', config('status.follow_post'))
                        ->update(['option' => config('status.reaction_post')]);
        } else if ($optionId == config('status.hide_post')) {
            $userPost = UserPost::updateOrCreate(
                ['post_id' => $postId, 'user_id' => $userId],
                ['post_id' => $postId, 'user_id' => $userId, 'option' => config('status.hide_post')]
            );
        } else if ($optionId == config('status.display_post')) {
            $userPost = UserPost::where('post_id', $postId)
                        ->where('user_id', $userId)
                        ->where('option', config('status.hide_post'))
                        ->update(['option' => config('status.reaction_post')]);
        } else if ($optionId == config('status.save_post')) {
            $userPost = UserPost::where('post_id', $postId)
                        ->where('user_id', $userId)
                        ->where('option', config('status.follow_post'))
                        ->first();
            if ($userPost) {
                $userPost = $userPost->update(['option' => config('status.save_and_follow_post')]);
            } else {
                $userPost = UserPost::updateOrCreate(
                    ['post_id' => $postId, 'user_id' => $userId],
                    ['post_id' => $postId, 'user_id' => $userId, 'option' => config('status.save_post')]
                );
            }
        } else if ($optionId == config('status.unsave_post')) {
            $userPost = UserPost::where('post_id', $postId)
                        ->where('user_id', $userId)
                        ->where('option', config('status.save_post'))
                        ->update(['option' => config('status.reaction_post')]);
        } else if ($optionId == config('status.notify_post')) {
            $userPost = UserPost::where('post_id', $postId)
                        ->where('user_id', $userId)
                        ->where(function($query) {
                            $query->where('option', config('status.save_post'))
                                ->orWhere('option', config('status.save_and_follow_post'));
                        })
                        ->first();
            if ($userPost) {
                $userPost = $userPost->update(['option' => config('status.save_and_notify_post')]);
            } else {
                $userPost = UserPost::updateOrCreate(
                    ['post_id' => $postId, 'user_id' => $userId],
                    ['post_id' => $postId, 'user_id' => $userId, 'option' => config('status.notify_post')]
                );
            }
        } else if ($optionId == config('status.no_notify_post')) {
            $userPost = UserPost::where('post_id', $postId)
                        ->where('user_id', $userId)
                        ->where('option', config('status.save_and_notify_post'))
                        ->first();
            if ($userPost) {
                $userPost = $userPost->update(['option' => config('status.save_post')]);
            } else {
                $userPost1 = UserPost::where('post_id', $postId)
                            ->where('user_id', $userId)
                            ->where('option', config('status.created_post'))
                            ->first();
                if($userPost1) {
                    $userPost = UserPost::updateOrCreate(
                        ['post_id' => $postId, 'user_id' => $userId],
                        ['post_id' => $postId, 'user_id' => $userId, 'option' => config('status.created_post')]
                    );
                } else {
                    $userPost = UserPost::updateOrCreate(
                        ['post_id' => $postId, 'user_id' => $userId],
                        ['post_id' => $postId, 'user_id' => $userId, 'option' => config('status.no_notify_post')]
                    );
                }
            }
        }

        return response()->json(['option_id' => $optionId]);
    }

    public function comment(Request $request)
    {
        $data['comment'] = $request->comment;
        $data['time_send'] = Carbon::createFromTimestampMs($request->time_send, 'Asia/Ho_Chi_Minh')->format('Y-m-d\TH:i:s');;
        $data['post_id'] = $request->post_id;
        $data['user_id'] = $request->user_id;
        $data['nums_like'] = 0;
        $comment = Comment::create($data);
        $userId = auth()->user()->id;
        $file = $request->file('f_media');
        if (!empty($file)) {
            $mime = $file->getMimeType();
            if (strstr($mime, "video/")){
                $type = config('status.video');
            } else if(strstr($mime, "image/")){
                $type = config('status.image');
            }
            $path = $file->storeAs('media', "comment$userId-" . $request->time_send . '.' . $file->getClientOriginalExtension(), 'public');
            $url = Storage::disk('public')->url($path);
            if (config('status.port')) {
                $url = str_replace('localhost', 'localhost:' . config('status.port'), $url);
            }
            Image::create([
                'name' => "comment$userId-" . $request->time_send . '.' . $file->getClientOriginalExtension(),
                'url' => $url,
                'type' => $type,
                'comment_id' => $comment->id
            ]);
            $data['images'] = $url;
            $data['images_type'] = $type;
        }
        $data['user_avatar'] = auth()->user()->avatar;
        $data['user_name'] = auth()->user()->name;
        $data['user_id'] = auth()->user()->id;
        $data['comment_id'] = $comment->id;

        $post = Post::find($data['post_id']);
        $postId = $post->id;
        $notification = [];
        $notification2 = [];
        if ($post->author != $data['user_id']) {
            $notification = Notification::create([
                'title' => 'Comment Post',
                'content' => '<small>' . $data['user_name'] . '</small> commented on your post',
                'link' => config('status.base_url') . "/post/$postId?comment_id=" . $data['comment_id'],
                'image' => auth()->user()->avatar
            ]);
            $notification->users()->attach($post->author, ['status' => config('status.unseen')]);
        }
        $userReceiveNotify = UserPost::where('post_id', $post->id)
                                    ->where(function($query) {
                                        $query->where('option', config('status.notify_post'))
                                            ->orWhere('option', config('status.save_and_notify_post'));
                                    })->get()->pluck('user_id')->toArray();
        if (($key = array_search($request->user_id, $userReceiveNotify)) !== false) {
            unset($userReceiveNotify[$key]);
        }
        if (!empty($userReceiveNotify)) {
            $notification2 = Notification::create([
                'title' => 'Comment Post',
                'content' => '<small>' . $data['user_name'] . '</small> commented on a post that you have been following',
                'link' => config('status.base_url') . "/post/$postId?comment_id=" . $data['comment_id'],
                'image' => auth()->user()->avatar
            ]);
            $notification2->users()->attach($userReceiveNotify, ['status' => config('status.unseen')]);
        }
        return response()->json(['data' => $data, 'notification' => $notification, 'notification2' => $notification2, 'user_send' => $request->user_id, 'user_receive' => $post->author, 'user_receive2' => $userReceiveNotify, 'user_avatar' => $data['user_avatar']]);
    }

    public function reply(Request $request)
    {
        $data['reply'] = $request->reply;
        $data['time_send'] = Carbon::createFromTimestampMs($request->time_send, 'Asia/Ho_Chi_Minh')->format('Y-m-d\TH:i:s');;
        $data['comment_id'] = $request->comment_id;
        $data['user_id'] = $request->user_id;
        $data['nums_like'] = 0;
        $reply = Reply::create($data);
        $userId = auth()->user()->id;
        $file = $request->file('f_media');
        if (!empty($file)) {
            $mime = $file->getMimeType();
            if (strstr($mime, "video/")){
                $type = config('status.video');
            } else if(strstr($mime, "image/")){
                $type = config('status.image');
            }
            $path = $file->storeAs('media', "reply$userId-" . $request->time_send . '.' . $file->getClientOriginalExtension(), 'public');
            $url = Storage::disk('public')->url($path);
            if (config('status.port')) {
                $url = str_replace('localhost', 'localhost:' . config('status.port'), $url);
            }
            Image::create([
                'name' => "reply$userId-" . $request->time_send . '.' . $file->getClientOriginalExtension(),
                'url' => $url,
                'type' => $type,
                'reply_id' => $reply->id
            ]);
            $data['images'] = $url;
            $data['images_type'] = $type;
        }
        $data['user_avatar'] = auth()->user()->avatar;
        $data['user_name'] = auth()->user()->name;
        $data['user_id'] = auth()->user()->id;
        $data['reply_id'] = $reply->id;

        $comment = Comment::with('user')->find($data['comment_id']);
        if ($comment->user->id != $data['user_id']) {
            $commentId = $comment->id;
            $postId = $comment->post_id;
            $notification = Notification::create([
                'title' => 'Reply Comment',
                'content' => '<small>' . $data['user_name'] . '</small> replied your comment',
                'link' => config('status.base_url') . "/post/$postId?comment_id=$commentId&reply_id=" . $data['reply_id'],
                'image' => auth()->user()->avatar
            ]);
            $notification->users()->attach($comment->user->id, ['status' => config('status.unseen')]);

            return response()->json(['data' => $data, 'notification' => $notification, 'user_receive' => $comment->user->id, 'user_avatar' => $data['user_avatar']]);
        }

        return response()->json(['data' => $data]);
    }

    public function loadMoreComments(Request $request)
    {
        $offset = $request->current_nums;
        $comments = Comment::where('post_id', $request->post_id)
            ->with('user', 'images')->orderBy('created_at', 'desc')->offset($offset)->limit(11)->get();
        $numsReplies = [];
        foreach ($comments as $comment) {
            $numsReplies[] = $comment->load(['replies' => function ($query) {
                $query->with('images', 'user')->offset(0)->limit(1);
            }])->replies()->get()->count();
        }
        $hasMoreComments = false;
        if ($comments->count() >= 11) {
            $hasMoreComments = true;
        }
        $commentsArray = $comments->toArray();
        for ($i = 0; $i < count($commentsArray); $i++) {
            $commentsArray[$i]['created_at'] = Carbon::parse($commentsArray[$i]['created_at'])->diffForHumans();
            for($j = 0; $j < count($commentsArray[$i]['replies']); $j++) {
                $commentsArray[$i]['replies'][$j]['created_at'] = Carbon::parse($commentsArray[$i]['replies'][$j]['created_at'])->diffForHumans();
            }
        }

        return response()->json(['data' => $commentsArray, 'nums_replies' => $numsReplies, 'has_more_comments' => $hasMoreComments]);
    }

    public function loadMoreReplies(Request $request)
    {
        $offset = $request->current_nums;
        $replies = Reply::where('comment_id', $request->comment_id)
            ->with('user', 'images')->orderBy('created_at', 'desc')->offset($offset)->limit(11)->get();

        $hasMoreReplies = false;
        if ($replies->count() >= 11) {
            $hasMoreReplies = true;
        }
        $repliesArray = $replies->toArray();
        for ($i = 0; $i < count($repliesArray); $i++) {
            $repliesArray[$i]['created_at'] = Carbon::parse($repliesArray[$i]['created_at'])->diffForHumans();
        }

        return response()->json(['data' => $repliesArray, 'has_more_replies' => $hasMoreReplies]);
    }

    public function seenAllNotification()
    {
        $userNotification = UserNotifications::where('user_id', auth()->user()->id)->update(['status' => config('status.seen')]);
        return $userNotification;
    }

    public function seenNotification(Request $request)
    {
        $notificationId = $request->notification_id;
        $update = UserNotifications::where('user_id', auth()->user()->id)->where('notification_id', $notificationId)->update(['status' => config('status.seen')]);

        return response()->json(['data' => $update]);
    }
}
