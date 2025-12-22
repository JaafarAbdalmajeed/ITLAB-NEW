@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $lab->title }}</h1>
    <div>{!! nl2br(e($lab->scenario)) !!}</div>
    <p><a href="{{ route('tracks.show', $track) }}">Back to track</a></p>
</div>
@endsection
