@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card-header">Anime</div>
	<ul class="anime list-group list-group-flush">
	@forelse ($list as $anime)
		<span style="margin: 0 auto;">
		<li class="list-group-item" style="float: left;">
		<a href="{{ url('anime/' . $anime->id) }}" />
			<img src="images/covers/{{ $anime->id }}.png" />
			<div class="overlay"></div>
			<p class="description">{{ $anime->name }}</p>
		</a>
		</li>
		</span>
	@empty
		<li class="list-group-item">No anime</li>
	@endforelse
	</ul>
</div>
@endsection