@extends('layouts.app')

@section('title', $track->title . ' - Lessons')
@section('body-class', 'page-lessons')

@section('content')
<div class="container">
    <h1>{{ $track->title }} - Lessons</h1>
    <p><a href="{{ route('tracks.show', $track) }}">← Back to {{ $track->title }}</a></p>

    @if($lessons->count() > 0)
        <ul style="list-style: none; padding: 0;">
            @foreach($lessons as $lesson)
                <li style="margin-bottom: 15px; padding: 15px; background: #1e293b; border-radius: 5px;">
                    <a href="{{ route('tracks.lessons.show', [$track, $lesson]) }}" style="color: #04aa6d; text-decoration: none; font-size: 18px; font-weight: 600;">
                        {{ $lesson->title }}
                    </a>
                    @if($lesson->order)
                        <span style="color: #9ca3af; margin-left: 10px;">Lesson {{ $lesson->order }}</span>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p style="color: #9ca3af;">No lessons available yet.</p>
    @endif
</div>
@endsection

