@php
    use Carbon\Carbon;
@endphp
<div class="background-main-light-mode main-left">
    <div class="main-left__btn">
        <span class="main-left__btn-open btn-main-menu left open">
            <i class="fas fa-chevron-right"></i>
        </span>
        <span class="main-left__btn-close btn-main-menu left close">
            <i class="fas fa-chevron-left"></i>
        </span>
    </div>
    <div class="personal-page-left">
        <div class="personal-top">
            <div class="personal-top__avatar avatar-big">
                <img class="image_zoom" src="{{ $data_user->avatar }}" alt="">
            </div>
            <div class="personal-top__name">
                <h4>{{ $data_user->name }}</h4>
                <small>{{ $data_user->description }}</small>
            </div>
            @if ($data_user->id != auth()->user()->id)
            <div class="personal-top__buttons">
                @if ($relation == config('status.no_relationship'))
                <span class="personal-top__buttons-add-friend add-friend btn btn-primary" friend_id="{{ $data_user->id }}">
                    <i class="fas fa-user-plus"></i>
                    Add friend
                </span>
                <span class="personal-top__buttons-add-friend request btn btn-warning hide-element" style="cursor: context-menu">
                    Requested
                </span>
                @elseif ($relation == config('status.request_me'))
                <div class="feedback-request-btn">
                    <span class="personal-top__buttons-add-friend btn btn-primary accept-request" friend_id="{{ $data_user->id }}">
                        Accept
                    </span>
                    <span class="personal-top__buttons-add-friend btn btn-outline-secondary reject-request" friend_id="{{ $data_user->id }}">
                        Reject
                    </span>
                    <span class="personal-top__buttons-add-friend btn btn-success accepted-request hide-element" style="cursor: context-menu">Accepted</span>
                    <span class="personal-top__buttons-add-friend btn btn-danger rejected-request hide-element" style="cursor: context-menu">Rejected</span>
                </div>
                @elseif ($relation == config('status.i_request'))
                    <span class="personal-top__buttons-add-friend btn btn-warning" style="cursor: context-menu">
                        Requested
                    </span>
                @else
                    <span class="personal-top__buttons-add-friend unfriend btn btn-primary" friend_id="{{ $data_user->id }}">
                        Unfriend
                    </span>
                    <span class="personal-top__buttons-add-friend add-friend btn btn-primary hide-element" friend_id="{{ $data_user->id }}">
                        <i class="fas fa-user-plus"></i>
                        Add friend
                    </span>
                    <span class="personal-top__buttons-add-friend request btn btn-warning hide-element" style="cursor: context-menu">
                        Requested
                    </span>
                @endif
                <span class="personal-top__buttons-message message btn btn-light" friend_id="{{ $data_user->id }}">
                    <i class="fab fa-facebook-messenger"></i>
                    Message
                </span>
            </div>
            @endif
        </div>
        <div class="personal-friends">
            <h4>
                Friends
                <small>({{ $nums_friend }})</small>
                @if ($data_user->id == auth()->user()->id)
                <a href="/personal/requests" class="btn btn-outline-primary your-request-btn">
                    Your requests
                </a>
                @endif
            </h4>
            <hr>
            <ul class="list-friends">
                @foreach ($data_friends as $friend)
                <li class="list-friends__item">
                    <a href="/other-personal/{{$friend->id}}">
                        <div class="avatar-mid">
                            <img src="{{ $friend->avatar }}" alt="">
                        </div>
                        <small>{{ $friend->name }}</small>
                    </a>
                </li>
                @endforeach
            </ul>
            <div class="personal-friends__button">
                @if ($data_user->id == auth()->user()->id)
                <a href="/personal/friends">See more</a>
                @else
                <a href="/other-personal/{{ $data_user->id }}/friends">See more</a>
                @endif
            </div>
        </div>
        <div class="personal-images">
            <h4>Images</h4>
            <hr>
            <ul class="list-images">
                @foreach ($user_images as $image)
                <li class="list-images__item">
                    <div class="personal-image">
                        <img class="image_zoom" src="{{ $image->url }}" alt="">
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="personal-images__button">
                @if ($data_user->id == auth()->user()->id)
                <a href="personal/images">See more</a>
                @else
                <a href="/other-personal/{{ $data_user->id }}/images">See more</a>
                @endif
            </div>
        </div>
        <div class="personal-information">
            <h4>Information</h4>
            <hr>
            @php
                if ($data_user->gender) {
                    if ($data_user->gender == config('status.male')) {
                        $gender = '<li>Male</li>';
                    } else if ($data_user->gender == config('status.female')) {
                        $gender = '<li>Female</li>';
                    } else {
                        $gender = '<li>Other</li>';
                    }
                } else {
                    $gender = '';
                }
            @endphp
            <ul>
                {!! $data_user->phone ? '<li>Phone: ' . $data_user->phone . '</li>' : '' !!}
                {!! $data_user->address ? '<li>Address: ' . $data_user->address . '</li>' : '' !!}
                {!! $gender !!}
                {!! $data_user->birthday ? '<li>Birthday: ' . Carbon::parse($data_user->birthday)->format('Y-m-d') . '</li>' : '' !!}
                {!! $data_user->introduce ? '<li>Introduce: ' . $data_user->introduce . '</li>' : ''!!}
            </ul>
        </div>
    </div>
    
</div>