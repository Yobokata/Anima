@extends('layouts.app', ['title' => $anime . ' Episode ' . $video->number])

@section('content')
<div class="container">
	@if(isset($anime) and isset($video))
		<div class="card-header episode-title">{{ $anime }} - Episode {{ $video->number }}</div>
		<video id="player" playsinline controls>
			<source src="../../../videos/{{ $video->anime_id . '/' . $video->id . '.' . $video->extension }}" type="video/webm">
			<!--<track kind="captions" label="English captions" src="../../../videos/{{ $video->anime_id . '/' . $video->id . '.srt' }}" srclang="en" default>-->
			Your browser does not support HTML5 video.
		</video>
		<p class="change-episode">
			@if($video->number > $startingEpisode)
				<a href="{{ ($video->number - 1) }}">Previous episode</a>
			@endif
			@if($video->number < $endingEpisode)
				<a href="{{ ($video->number + 1) }}">Next episode</a>
			@endif
		</p>
		@if($video->bad_subs)
			<p>Warning: Bad subs</p>
		@endif
	@else
		<p><center>Invalid url<center></p>
	@endif
</div>
@endsection