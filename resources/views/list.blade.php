@extends('layouts.app')

@section('content')
<div class="container">
	<div class="card-header">Anime</div>
	<div class="card">
		<ul class="anime list-group list-group-flush">
		@forelse ($list as $anime)
			<li class="list-group-item">
			<a href="{{ url('anime/' . $anime->name) }}" />
			@if ($anime->image != null)
				<img src="{{ $anime->image }}" />
			@else
				<img src="images/no_image.png" />
			@endif
			{{ $anime->name }}
			</a>
			</li>
		@empty
			<li class="list-group-item">No anime</li>
		@endforelse
		</ul>
	</div>
</div>
@endsection