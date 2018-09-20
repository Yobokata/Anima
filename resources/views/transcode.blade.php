@extends('layouts.app')

@section('content')

<div class="container">
    <div class="input-group" >
        <input type="text" class="form-control" name="anime_name" list="animeList"/>
        <datalist id="animeList">
            @forelse ($anime_list as $anime_name)
            <option class="dropdown-item" value="{{ $anime_name->name }}">{{ $anime_name->name }}</option>
            @empty
                @if($anime_list != null)
                <option class="dropdown-item" value="No anime">No anime</option>
                @endif
            @endforelse
        </datalist>
        <span class="input-group-btn">
            <button type="button" class="btn btn-warning" onclick="getTranscodeLines()">Transcode</button>
        </span>
        </div>
    <div class="terminal">Transcoding terminal V 1.3<br /></div>
</div>

<script>
    function getTranscodeLines() {
        $.ajax({
            type:'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: '/transcode_anime',
            data: { anime_name: $('input[name=anime_name]').val() },
            success: function(data, status, jqXHR) {
                console.log('done');
                $('.terminal').append(data);
            },
            failure: function() {
                console.log('failed');
            },
            error: function() {
                alert('an error occurred');
            }
        });
    }
</script>

@endsection