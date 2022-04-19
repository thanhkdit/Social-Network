@extends('master.master')
@section('title', 'News feed')
@section('content')
@php
use Carbon\Carbon;
@endphp
<div class="main-content">
    <div class="background-main-light-mode up-post">
        <div class="up-post__top">
            <span class="avatar">
                <img src="images/profile-pic.png" alt="">
            </span>
            <div class="up-post__top-btn">
                What's on your mind?
            </div>
        </div>
        <ul class="up-post__bottom">
            <li class="up-post__bottom-video">
                <i class="fas fa-film"></i>
                <small>Video</small>
            </li>
            <li class="up-post__bottom-image">
                <i class="far fa-image"></i>
                <small>Image</small>
            </li>
            <li class="up-post__bottom-file">
                <i class="fas fa-heartbeat"></i>
                <small>Feeling</small>
            </li>
            <li class="up-post__bottom-action">
                <i class="far fa-kiss-beam"></i>
                <small>Activity</small>
            </li>
        </ul>
    </div>

    <div class="list-news-feed">
        @foreach ($posts as $post)
        @php
        $postOption = 0;
        $postReaction = 0;
        if (auth()->user()->userPosts->find($post->id)) {
            $postOption = auth()->user()->userPosts->find($post->id)->pivot->option;
            $postReaction = auth()->user()->userPosts->find($post->id)->pivot->reaction;
        }
        @endphp
        <div class="new-feed background-main-light-mode" post_id="{{ $post->id }}">
            <div class="new-feed__btn">
                <i class="fas fa-ellipsis-h"></i>
                <ul class="functions">
                    @if ($post->author == auth()->user()->id)
                        <li class="functions-item delete-post">
                            <i class="fas fa-trash-alt"></i>
                            <span>Delete post</span>
                        </li>
                    @endif
                    @if ($postOption == config('status.save_post') || $postOption == config('status.save_and_follow_post'))
                        <li class="functions-item save-post" option_id="{{ config('status.unsave_post') }}">
                            <i class="far fa-save"></i>
                            <span>Don't save this post</span>
                        </li>
                    @else
                        <li class="functions-item save-post" option_id="{{ config('status.save_post') }}">
                            <i class="far fa-save"></i>
                            <span>Save this post</span>
                        </li>
                    @endif
                    @if ($postOption == config('status.hide_post') )
                        <li class="functions-item hide-post" option_id="{{ config('status.display_post') }}">
                            <i class="far fa-eye"></i>
                            <span>Display this post</span>
                        </li>
                    @else
                        <li class="functions-item hide-post" option_id="{{ config('status.hide_post') }}">
                            <i class="far fa-eye-slash"></i>
                            <span>Hide this post</span>
                        </li>
                    @endif
                    @if ($postOption == config('status.notify_post') || $postOption == config('status.save_and_notify_post'))
                        <li class="functions-item turn-off-noti" option_id="{{ config('status.no_notify_post') }}">
                            <i class="far fa-times-circle"></i>
                            <span>Turn off notification</span>
                        </li>
                    @else
                        <li class="functions-item turn-on-noti" option_id="{{ config('status.notify_post') }}">
                            <i class="far fa-bell"></i>
                            <span>Turn on notification</span>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="new-feed__top">
                <a href="/other-personal/{{ $post->user->id }}" class="avatar">
                    <img src="{{ $post->user->avatar }}" alt="">
                </a>
                <div class="new-feed__info">
                    <span class="new-feed__info-poster">
                        <a class="new-feed__info-poster__name" href="/other-personal/{{ $post->user->id }}">{{ $post->user->name }}</a>
                        {{-- <a href="#" class="in-group">
                            <i class="fas fa-caret-right"></i>
                            Hội nhóm siêu cấp vô địch vũ trụ
                        </a> --}}
                        <span>
                        @if ($post->feeling)
                            <i class="i-feeling">is feeling </i>
                            <b class="b-feeling">{{ $post->feeling }}</b>
                        @endif
                        @if (!$post->tagUsers->isEmpty())
                            <i class="i-with">with </i>
                            <b class="b-with"><a href="/other-personal/{{ $post->tagUsers[0]->id }}">{{ $post->tagUsers[0]->name }}</a></b>
                        @endif
                        @if ($post->location)
                            <i class="i-at">at </i>
                            <b class="b-at">{{ $post->location }}</b>
                        @endif
                        </span>
                    </span>
                    <a href="/post/{{$post->id}}" style="text-decoration: none" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';" class="new-feed__info-time">
                        <?php
                            echo Carbon::parse($post->time)->diffForHumans();
                        ?>
                    </a>
                </div>
            </div>
            <div class="new-feed__content">
                <div class="new-feed__content-text content-truncate">
                    <p class="url-text">{{ $post->content }}</p>
                    <div class="read-more">
                        read more
                    </div>
                    <div class="read-less">
                        read less
                    </div>
                </div>
            </div>
            <div class="photos-video {{ count($post->images) > 1 ? 'multi' : '' }}">
                @foreach ($post->images as $image)
                    @if ($image->type == config('status.image'))
                        <div class="photos-video__item">
                            <img class="image_zoom photos-video__item" src="{{ $image->url }}" alt="">
                        </div>
                    @elseif ($image->type == config('status.video'))
                        <div class="video video_zoom photos-video__item">
                            <video src="{{ $image->url }}"></video>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="new-feed__bottom">
                <div class="new-feed__bottom-interaction">
                    <div class="like-nums">
                        <i class="fas fa-thumbs-up"></i>
                        <span>{{ $post->nums_like }}</span>
                    </div>
                    <div class="comment-nums">
                        {{ sizeof($post->comments) }} Comments
                    </div>
                </div>
                <ul class="new-feed__bottom-btn">
                    <li class="btn-like post {{ $postReaction != config('status.no_reaction') ? 'like' : '' }}">
                        <i class="far fa-thumbs-up fa-rotate-45"></i>
                        <span>Like</span>
                    </li>
                    <li class="btn-comment">
                        <i class="far fa-comment-alt"></i>
                        <span>Comment</span>
                    </li>
                    <li class="btn-share">
                        <i class="far fa-share-square"></i>
                        <span>Share</span>
                    </li>
                </ul>
                <div class="new-feed__bottom-comment">
                    <div class="box-comment">
                        <span class="avatar online">
                            <img src="{{ auth()->user()->avatar }}" alt="">
                        </span>
                        <form method="post" action="#" class="form-input-comment" enctype="multipart/form-data">
                            <input autocomplete="off" type="text" class="input-comment" placeholder="Write public comment ...">
                            <div class="form-input-comment__btn">
                                <label for="comment-file-input-{{ $post->id }}" class="fas fa-photo-video"></label>
                                <input autocomplete="off" name="f_media" id="comment-file-input-{{ $post->id }}" type="file" hidden>
                            </div>
                            <button type="submit"><i class="fas fa-paper-plane"></i></button>
                        </form>
                    </div>
                </div>
                <ul class="list-comments comment">
                    @foreach ($post->comments()->orderBy('created_at', 'desc')->offset(0)->limit(3)->get() as $comment)
                    <li class="list-comments__item comment" comment_id="{{ $comment->id }}">
                        <a href="/other-personal/{{ $comment->user->id }}" class="avatar">
                            <img src="{{ $comment->user->avatar }}" alt="">
                        </a>
                        <div class="list-comments__item-content">
                            <div class="list-comments__item-content__text content-truncate">
                                <a href="/other-personal/{{ $comment->user->id }}">{{ $comment->user->name }}</a>
                                <div class="comment">
                                    <p class="url-text">{{ $comment->comment }}</p>
                                    <div class="read-more">
                                        read more
                                    </div>
                                    <div class="read-less">
                                        read less
                                    </div>
                                    @foreach ($comment->images as $image)
                                    @if ($image->type == config('status.image'))
                                        <div class="photos-video__item">
                                            <img class="image_zoom photos-video__item" src="{{ $image->url }}" alt="">
                                        </div>
                                    @else
                                        <div class="video video_zoom photos-video__item">
                                            <video src="{{ $image->url }}"></video>
                                        </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="comment nums-like {{ $comment->nums_like > 0 ? '' : 'hide-element' }}">
                                    <i class="fas fa-thumbs-up"></i>
                                    <span>{{ $comment->nums_like }}</span>
                                </div>
                            </div>
                            <div class="list-comments__item-content__buttons">
                                <span class="btn-like comment {{ $comment->nums_like > 0 ? 'like' : '' }}">Like</span>
                                <span class="btn-reply">Reply</span>
                                <span class="time">
                                    <?php
                                        echo Carbon::parse($comment->created_at)->diffForHumans();
                                    ?>
                                </span>
                            </div>
                            <div class="list-comments__item-content__reply">
                                <div class="box-reply">
                                    <span class="avatar online">
                                        <img src="{{ auth()->user()->avatar }}" alt="">
                                    </span>
                                    <form method="post" action="#" class="form-input-reply" enctype="multipart/form-data">
                                        <input autocomplete="off" type="text" class="input-reply" placeholder="Reply ...">
                                        <div class="form-input-reply__btn">
                                            <label for="reply-file-input-{{ $comment->id }}" class="fas fa-photo-video"></label>
                                            <input autocomplete="off" name="f_media" id="reply-file-input-{{ $comment->id }}" type="file" hidden>
                                        </div>
                                        <button type="submit"><i class="fas fa-paper-plane"></i></button>
                                    </form>
                                </div>
                            </div>
                            <ul class="list-comments reply" comment_id="{{ $comment->id }}">
                                @foreach ($comment->replies()->orderBy('created_at', 'desc')->offset(0)->limit(1)->get() as $reply)
                                <li class="list-comments__item reply" reply_id="{{ $reply->id }}">
                                    <a href="/other-personal/{{ $reply->user->id }}" class="avatar">
                                        <img src="{{ $reply->user->avatar }}" alt="">
                                    </a>
                                    <div class="list-comments__item-content">
                                        <div class="list-comments__item-content__text content-truncate">
                                            <a href="/other-personal/{{ $reply->user->id }}">{{ $reply->user->name }}</a>
                                            <div class="comment">
                                                <p class="url-text">{{ $reply->reply }}</p>
                                                <div class="read-more">
                                                    read more
                                                </div>
                                                <div class="read-less">
                                                    read less
                                                </div>
                                                @foreach ($reply->images as $image)
                                                @if ($image->type == config('status.image'))
                                                    <div class="photos-video__item">
                                                        <img class="image_zoom photos-video__item" src="{{ $image->url }}" alt="">
                                                    </div>
                                                @else
                                                    <div class="video video_zoom photos-video__item">
                                                        <video src="{{ $image->url }}"></video>
                                                    </div>
                                                @endif
                                                @endforeach
                                            </div>
                                            <div class="reply nums-like {{ $reply->nums_like > 0 ? '' : 'hide-element' }}">
                                                <i class="fas fa-thumbs-up"></i>
                                                <span>{{ $reply->nums_like }}</span>
                                            </div>
                                        </div>
                                        <div class="list-comments__item-content__buttons">
                                            <span class="btn-like reply {{ $reply->nums_like > 0 ? 'like' : '' }}">Like</span>
                                            <span class="time">          
                                                <?php
                                                    echo Carbon::parse($reply->created_at)->diffForHumans();
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            @if (count($comment->replies) > 1)
                            <div class="load-more-comments reply">
                                Load more replies
                            </div>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>
                @if (count($post->comments) > 3)
                <div class="load-more-comments comment">
                    Load more comments
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
