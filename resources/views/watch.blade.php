@extends('layouts.app')

@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			@if(isset($video))
				<video controls  type="video/webm">
					<source src="../../../videos/{{ $video->anime_id . '/' . $video->id . '.' . $video->extension}}">
					Your browser does not support HTML5 video.
				</video>
				<div class="underlay"></div>
				<a class="nextEpisode" href="{{ ($video->number - 1) }}">Previous episode</a>
				<a class="nextEpisode" href="{{ ($video->number + 1) }}">Next episode</a>
				@if($video->bad_subs)
					<p>Warning: Bad subs</p>
				@endif
			@else
				<p><center>Invalid url<center></p>
			@endif
		</div>
	</div>
	<script src="../../../js/videoControls.js"></script>
</div>
@endsection