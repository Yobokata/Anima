@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card-header">Anime</div>
	<div class="card">
		<ul class="anime list-group list-group-flush">
		@forelse ($list as $anime)
			<li class="list-group-item">
			<a href="{{ url('anime/' . $anime->id) }}" />
			@if ($anime->image != null)
				<img src="{{ $anime->image }}" />
			@else
				<img src="images/no_image.png" />
			@endif
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