@php
use Carbon\Carbon;
@endphp
<div class="main-right">
    <div class="main-right__btn">
        <span class="main-right__btn-close btn-main-menu right close">
            <i class="fas fa-chevron-right"></i>
        </span>
        <span class="main-right__btn-open btn-main-menu right open">
            <i class="fas fa-chevron-left"></i>
        </span>
    </div>
    <div class="main-right__inner">
        <div class="calendar">
            <div class="calendar__header">
                <h4>Calendar</h4>
                <div class="calendar__header-btn">
                    <span id="btn_sync_calendar" class="btn btn-outline-primary"><i class="fas fa-sync-alt"></i></span>
                    <span id="btn_add_calendar" class="btn btn-outline-primary">+</span>
                    <span id="btn_delete_all_calendar" class="btn btn-outline-danger">Delete All</span>
                </div>
            </div>
            <div class="scroll-calendar">
                <ul class="calendar__items">
                    @foreach ($calendars as $item)
                    <li class="calendar__item">
                        <input autocomplete="off" hidden class="calendar__item-time" type="text" value="{{ $item->time }}">
                        <div class="calendar__item__detail">
                            <div class="box-calendar">
                                <div class="box-calendar__day">
                                    {{ Carbon::createFromFormat('Y-m-d H:i:s', $item->time)->day }}
                                </div>
                                <div class="box-calendar__month">
                                    {{ substr(Carbon::createFromFormat('Y-m-d H:i:s', $item->time)->format('F'), 0, 3) }}
                                </div>
                            </div>
                            <div class="calendar__item__detail-content">
                                <b>{{ $item->title }}</b>
                                <p>
                                    {{ $item->content }}
                                </p>
                            </div>
                        </div>
                        <div class="calendar__item-action">
                            <div class="delete" calendar-id="{{ $item->id }}">
                                <i class="fas fa-trash-alt"></i>
                            </div>
                            <div class="cancel">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>
                        <span class="btn-minus"><i class="fas fa-minus"></i></span>
                    </li>
                    @endforeach
                    <li class="not-have alert alert-info">This is an empty</li>
                </ul>
            </div>
        </div>
        <div class="user-online">
            <div class="user-online__header">
                <h4>Online</h4>
            </div>
            <form id="form_user_online" action="/get_tab_chat" method="post">
                <div class="scroll-user-online">
                    <ul class="user-online__list">
                        @foreach($user_online as $row)
                        <li class="user-online__list-item" user_id="{{ $row->friend_id }}">
                            <div class="avatar online">
                                <img src="{{ $row->avatar }}" alt="">
                            </div>
                            <div class="username">
                                <p>{{$row->name}}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <div class="scroll-user-online__bottom">

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>