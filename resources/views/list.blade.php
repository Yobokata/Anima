@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card-header">Anime</div>
	<div class="card">
		<ul class="anime list-group list-group-flush">
		@forelse ($list as $anime)
			<li class="list-group-item">
			<a href="{{ url('anime/' . $anime->id) }}" />
				<img src="images/covers/{{ $anime->id }}.png" />
				<div class="overlay"></div>
				<p class="description">{{ $anime->name }}</p>
			</a>
			</li>
		@empty
			<li class="list-group-item">No anime</li>
		@endforelse
		</ul>
	</div>
</div>
@endsection