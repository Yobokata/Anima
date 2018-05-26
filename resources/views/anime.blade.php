@extends('layouts.app', ['title' => $anime->name . ' (' . $anime->alt_name . ')' ])

@section('content')
<div class="container">
	<div class="card cover" style="float: left; width: 20%;">
		@if($anime != null)
			<!-- need to check if the cover exists here -->
			<img src="../images/covers/{{ $anime->id }}.png" />
		@else
			Anime does not exist or has not been added yet
		@endif
	</div>
	<div class="card-header name" style="float: left; width: 80%;">
		{{ $anime->name }}
		@isset($anime->alt_name)
		({{ $anime->alt_name }})
		@endisset
	</div>
	<div class="card list" style="float: left; width: 80%;">
		<ul class="episode list-group list-group-flush">
		@forelse ($episodeList as $episode)
			<li class="list-group-item"><a href="{{ url('watch/' . $anime->id .'/' . $episode->number) }}" />{{ 'Episode ' . $episode->number }}</a></li>
		@empty
			@if($anime != null)
				<li class="list-group-item">No episodes</li>
			@endif
		@endforelse
		</ul>
	</div>
</div>
@endsection