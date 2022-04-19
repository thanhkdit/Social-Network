@extends('master.personal')
@section('title', 'Friend')
@section('content')

<div class="main-content-user-images">
  <div class="list-user-images">
    @foreach($data_all_images as $image)
    @if ($image->type == config('status.image'))
      <img class="image_zoom" src="{{ $image->url }}" alt="">
    @else
      <div class="video video_zoom photos-video__item" style="width: 243.32px">
          <video src="{{ $image->url }}" style="width: 100%"></video>
      </div>
    @endif
    @endforeach
  </div>
</div>

@endsection
