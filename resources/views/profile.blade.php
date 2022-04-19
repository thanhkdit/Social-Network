@extends('master.profile')
@section('title', 'Friend')
@section('content')
@php
    $user = auth()->user();
@endphp
    <div class="main-content-profile">
      <h2>Profile</h2>
      <form class="row g-3 needs-validation" method="post" enctype="multipart/form-data" action="/profile/update" novalidate>
        @csrf
        <div class="form-left col-md-4">
          <label for="profile-avatar" class="form-left-avatar">
            <img src="{{ auth()->user()->avatar }}" alt="">
          </label> 
          <input type="file" hidden class="form-control" name="avatar" id="profile-avatar" accept="image/*">
          <p style="font-size: 13px;">Name: {{ $user->name }}</p>
          <p style="font-size: 13px">Description: {{ $user->description }}</p>
          <p style="font-size: 13px">Introduce: {{ $user->introduce }}</p>
          <p style="font-size: 13px">Birthday: {{ $user->birthday }}</p>
          <p style="font-size: 13px">Address: {{ $user->address }}</p>
          <p style="font-size: 13px">Phone: {{ $user->phone }}</p>
        </div>
        <div class="col-md-7 form-right">
          <div class="col-md-12">
            <label for="validationCustom01" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" id="validationCustom01" value="{{$user->name}}" required>
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>
          <div class="col-md-12">
            <label for="validationCustom02" class="form-label">Description</label>
            <input type="text" class="form-control" name="description" id="validationCustom02" value="{{$user->description}}">
          </div>
          <div class="col-md-12">
            <label for="validationCustom12" class="form-label">Phone</label>
            <input type="number" class="form-control" name="phone" id="validationCustom12" value="{{$user->phone}}">
          </div> 
          <div class="col-md-12">
            <label for="validationCustomUsername" class="form-label">Birthday</label>
            <div class="input-group">
              <input type="date" class="form-control" name="birthday" id="validationCustomUsername" value="{{$user->birthday}}">
            </div>
          </div>
          <div class="col-md-12">
            <label for="validationCustom03" class="form-label">Address</label>
            <input type="text" class="form-control" name="address" id="validationCustom03" value="{{$user->address}}">
          </div>
          <div class="col-md-12">
            <label for="validationCustom05" class="form-label">Introduce</label>
            <textarea type="text" class="form-control" name="introduce" id="validationCustom05">{{$user->introduce}}</textarea>
          </div>
          <div class="col-12 btn-submit-profile">
            <button class="btn btn-primary" type="submit">Submit</button>
          </div>
        </div>
      </form>
    </div>
@endsection