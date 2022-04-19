<?php 
use Carbon\Carbon;
$now = Carbon::now();
?>
<!-- Nav -->
<nav>
    <div class="nav-inner container-1">
        <div class="nav-left">
            <div class="logo">
                <a href="/"><img src="images/logo.png" alt="socialbook" class="logo"></a>
            </div>
            <div class="back-search">
                <i class="fas fa-arrow-left"></i>
            </div>
            <div class="box-search">
                <i class="fas fa-search"></i>
                <input autocomplete="off" id="nav-left__search" type="text" placeholder="Search...">
                <div class="box-search__result mini">
                    <ul>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="nav-mid">
            <div class="box-search">
                <i class="fas fa-search"></i>
                <input autocomplete="off" id="nav-mid__search" type="text" placeholder="Search...">
                <div class="box-search__result">
                    <ul>
                    </ul>
                </div>
            </div>
            <div class="bars">
                <i class="fas fa-bars"></i>
            </div>
            @php
                if (!isset($active_filter)) {
                    $active_filter = 1;
                }
            @endphp
            <div class="filter-post">
                <a href="/" style="text-decoration: none" class="filter-post__icon filter-post__all {{ $active_filter == 1 ? 'selected' : ''}}">
                    <i class="fas fa-ellipsis-h"></i>
                </a>
                <a href="/?filter=2" style="text-decoration: none" class="filter-post__icon filter-post__video {{ $active_filter == 2 ? 'selected' : ''}}">
                    <i class="fas fa-video"></i>
                </a>
                <a href="/?filter=1" style="text-decoration: none" class="filter-post__icon filter-post__friend {{ $active_filter == 3 ? 'selected' : ''}}">
                    <i class="fas fa-user-friends"></i> 
                </a>
            </div>
        </div>

        <div class="nav-right">
            <div class="nav-right__buttons">
                <div class="nav-right__buttons-item btn_notification nav-notification">
                    <i class="far fa-bell"></i>
                    <span class="new-notification">
                        
                    </span>
                </div>

                <div class="nav-right__buttons-item btn_notification nav-message">
                    <i class="fab fa-facebook-messenger"></i>
                    <span class="new-notification {{ $earlier_messages['nums_messages_unseen'] == 0 ? 'hide' : '' }}">
                    {{$earlier_messages['nums_messages_unseen']}}
                    </span>
                </div>

                <div class="nav-right__buttons-item nav-setting">
                    <i class="fas fa-cog"></i>
                </div>

                <div class="avatar online">
                    <a href="">
                        <a href="/personal"><img src="{{ auth()->user()->avatar }}" alt="sdaf"></a>
                    </a>
                </div>
            </div>
            <div class="nav-right__content">
                <ul class="nav-notification__content">
                    <li class="nav-notification__content-title">
                        <h4>Notifications</h4>
                        <span class="btn btn-outline-primary nav-notification__seen"><i class="fas fa-check"></i> Seen</span>
                    </li>
                    <li>
                        <ul>
                            <li class="nav-notification__content-title new">
                                <h5>New</h5>
                            </li>
                            @foreach($notifications as $index => $notification)
                            @if ($index == 3)
                                <li class="nav-notification__content-title old">
                                    <h5>Earlier</h5>
                                </li>
                            @endif
                            <li class="{{ $notification->status == config('status.unseen') ? 'unseen' : '' }}" notification_id="{{ $notification->notification->id }}">
                                <a href="{{ $notification->notification->link }}">
                                    <div class="avatar">
                                        <img src="{{ $notification->notification->image }}" alt="">
                                    </div>
                                    <div>
                                        <span>{!! $notification->notification->content !!}</span>
                                        <small>{{ Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    
                </ul>
                <ul class="nav-messages__content">
                    <li class="nav-messages__content-title">
                        <h4>
                            Messages
                        </h4>
                    </li>
                    <li class="nav-messages__content-search">
                        <div class="back-search">
                            <i class="fas fa-arrow-left"></i>
                        </div>
                        <div class="box-search active">
                            <i class="fas fa-search"></i>
                            <input autocomplete="off" id="input-search-message" type="text" placeholder="Search...">
                        </div>
                    </li>
                    <li class="messages-content">
                    <ul>
                        @foreach ($earlier_messages['list_messages'] as $key => $row)
                            <li class="message-content__item user_id_{{$earlier_messages['list_rooms'][$key]->id}} {{$earlier_messages['list_status_seen'][$key]}}" user_id="{{$earlier_messages['list_rooms'][$key]->id}}">
                                <div class="avatar">
                                    <img src="{{$earlier_messages['list_rooms'][$key]->avatar}}" alt="">
                                </div>
                                <div>
                                    <span>{{$earlier_messages['list_rooms'][$key]->name}}</span>
                                    <p>
                                        <?php 
                                            if ($row->name == Auth::user()->name) {
                                                echo "You: ";
                                            }
                                        ?>
                                        {{$row->message ? $row->message : 'Sent an image'}}
                                    </p>
                                    <small>
                                        <?php
                                            $row_time = Carbon::createFromFormat('Y-m-d H:i:s',$row->time);
                                            $earlier_message_time = $row_time->diffForHumans();
                                            echo $earlier_message_time;
                                        ?>
                                    </small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    </li>
                    <li class="search-result">
                        <ul>

                        </ul>
                    </li>
                </ul>
                <ul class="nav-setting__content">
                    <li>
                        <i class="fas fa-moon"></i>
                        <span>Dark Mode</span>
                        <div class="btn-switch dark-mode">
                            <div class="round"></div>
                        </div>
                    </li>
                    <li>
                        <i class="fas fa-book-open"></i>
                        <span>Read Only</span>
                        <div class="btn-switch read-mode">
                            <div class="round"></div>
                        </div>
                    </li>
                    <hr>
                    <li>
                        <a href="/profile">
                            <i class="fas fa-user-edit"></i>
                            Edit profile
                        </a>
                    </li>
                    <li>
                    <a href="{{route('password.request', ['token' => csrf_token()])}}" type="submit">
                        <i class="fas fa-key"></i>
                        Change your password
                    </a>
                    </li>
                    <li>
                    {{-- <a href="{{route('logout')}}">
                        <i class="fas fa-sign-out-alt"></i>
                        Log out
                    </a> --}}
                    <form action="{{route('logout')}}" method="POST">
                        @csrf
                        <button type='submit' class="log-out-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            Log out
                        </button>
                    </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- End Nav -->