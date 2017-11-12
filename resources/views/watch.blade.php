@extends('layouts.app')

@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			@isset($video)
			<video controls  type="video/webm">
				<source src="../../../videos/Encoded/{{ $video->name . '/' . $video->name . '_' . $video->number . '_sub.' . $video->extension}}">
				Your browser does not support HTML5 video.
			</video>
			<a class="nextEpisode" href="{{ ($video->number - 1) }}">Previous episode</a>
			<a class="nextEpisode" href="{{ ($video->number + 1) }}">Next episode</a>
			@endisset
			@empty($video)
			<p>Invalid url</p>
			@endempty
		</div>
	</div>
	<!--<script src="../../../js/loadNextEpisode.js"></script>-->
</div>
@endsection