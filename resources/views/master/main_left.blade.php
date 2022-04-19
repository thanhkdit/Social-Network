
<div class="main-left">
    <div class="main-left__btn">
        <span class="main-left__btn-open btn-main-menu left open">
            <i class="fas fa-chevron-right"></i>
        </span>
        <span class="main-left__btn-close btn-main-menu left close">
            <i class="fas fa-chevron-left"></i>
        </span>
    </div>
    <div class="main-left__item main-left__category">
        <div class="main-left__item-title">
            <a href="/personal">
                <span class="avatar">
                    <img src="{{ auth()->user()->avatar }}" alt="">
                </span>
                <h4>
                    {{Auth::user()->name}}
                </h4>
            </a>
        </div>
        <ul>
            <li><a href="/personal/friends"><i class="fas fa-user-friends"></i><span>Friends</span></a></li>
            <li><a href="/?filter=2"><i class="fas fa-video"></i></i><span>Videos</span></a></li>
            <li><a href="?saved=1"><i class="fas fa-save"></i></i><span>Saved</span></a></li>
            <li><a href="?hide=1"><i class="fas fa-trash-alt"></i><span>Trash</span></a></li>
        </ul>
    </div>
    <div class="main-left__item main-left__recently">
        <h4 class="main-left__item-title">Recently</h4>
        <ul>
            @foreach ($earlier_messages['list_messages'] as $key => $row)
            @if ($key < 7)
            <li>
                <a href="/other-personal/{{$earlier_messages['list_rooms'][$key]->id}}">
                    <div class="avatar">
                        <img src="{{$earlier_messages['list_rooms'][$key]->avatar}}" alt="">
                    </div>
                    <span>{{$earlier_messages['list_rooms'][$key]->name}}</span>
                </a>
            </li>
            @endif
            @endforeach
        </ul>
    </div>
</div>