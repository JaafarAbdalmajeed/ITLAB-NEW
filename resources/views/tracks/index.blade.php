@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tracks</h1>

    <ul>
    @foreach($tracks as $track)
        <li><a href="{{ route('tracks.show', $track) }}">{{ $track->title }} ({{ $track->slug }})</a></li>
    @endforeach
    </ul>
</div>
@endsection
