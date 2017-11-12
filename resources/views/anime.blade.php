@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card cover">
		@if($anime != null)
			<img src="{{ $anime->image }}" />
		@else
			Anime does not exist or has not been added yet
		@endif
	</div>
	<div class="card-header name">
		{{ $anime->name }}
		@isset($anime->alt_name)
		({{ $anime->alt_name }})
		@endisset
	</div>
	<div class="card list">
		<ul class="episode list-group list-group-flush">
		@forelse ($episodeList as $episode)
			<li class="list-group-item"><a href="{{ url('watch/' . $episode->name .'/' . $episode->number) }}" />{{ 'Episode ' . $episode->number }}</a></li>
		@empty
			@if($anime != null)
			<li class="list-group-item">No episodes</li>
			@endif
		@endforelse
		</ul>
	</div>
</div>
@endsection