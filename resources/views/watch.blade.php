@extends('layouts.app')

@section('content')
<div class="container">
	@if(isset($anime) and isset($video))
		<div class="card-header episode-title">{{ $anime }} - Episode {{ $video->number }}</div>
		<video id="player" playsinline controls>
			<source src="../../../videos/{{ $video->anime_id . '/' . $video->id . '.' . $video->extension }}" type="video/webm">
			Your browser does not support HTML5 video.
		</video>
		<p class="change-episode">
			<a href="{{ ($video->number - 1) }}">Previous episode</a>
			<a href="{{ ($video->number + 1) }}">Next episode</a>
		</p>
		@if($video->bad_subs)
			<p>Warning: Bad subs</p>
		@endif
	@else
		<p><center>Invalid url<center></p>
	@endif


</div>
@endsection