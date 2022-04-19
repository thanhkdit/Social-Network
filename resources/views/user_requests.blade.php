@extends('master.personal')
@section('title', 'Request')
@section('content')
@php
use Carbon\Carbon;
@endphp
<div class="main-content-user-friends">
  <h3 class="mb-3">{{ count($data_requests) }} Requests</h3>
  <div class="list-user-friends">
    @foreach($data_requests as $request)
    <div class="card-friend">
      <a href="/other-personal/{{ $request->id }}"><img src="{{ $request->avatar }}" alt="dsfdsf"></a>
      <h4>{{ $request->name }}</h4>
      <p>{{ $request->description }}</p>
      <div class="card-friend__buttons">
          <span class="btn btn-primary accept-request" friend_id="{{ $request->id }}">Accept</span>
          <span class="btn btn-outline-secondary reject-request" friend_id="{{ $request->id }}">Reject</span>
          <span class="btn btn-success accepted-request hide-element" style="cursor: context-menu">Accepted</span>
          <span class="btn btn-danger rejected-request hide-element" style="cursor: context-menu">Rejected</span>
      </div>
    </div>
    @endforeach
  </div>
</div>

@endsection
