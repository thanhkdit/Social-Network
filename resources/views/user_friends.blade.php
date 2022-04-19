@extends('master.personal')
@section('title', 'Friend')
@section('content')
@php
use Carbon\Carbon;
@endphp
<div class="main-content-user-friends">
  <div class="list-user-friends">
    @foreach($data_all_friends as $friend)
    <div class="card-friend">
      <a href="/other-personal/{{ $friend->id }}"><img src="{{ $friend->avatar }}" alt="dsfdsf"></a>
      <h4>{{ $friend->name }}</h4>
      <p>{{ $friend->description }}</p>
      {{-- <div class="card-friend__buttons">
          <span class="btn btn-primary">Accept</span>
          <span class="btn btn-outline-secondary">Reject</span>
      </div> --}}
    </div>
    @endforeach
  </div>
</div>

@endsection
