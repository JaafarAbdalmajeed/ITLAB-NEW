@extends('layouts.app')

@section('title', $track->title . ' - Quizzes')
@section('body-class', 'page-quizzes')

@section('content')
<div class="container">
    <h1>{{ $track->title }} - Quizzes</h1>
    <p><a href="{{ route('tracks.show', $track) }}">← Back to {{ $track->title }}</a></p>

    @if($quizzes->count() > 0)
        <ul style="list-style: none; padding: 0;">
            @foreach($quizzes as $quiz)
                <li style="margin-bottom: 15px; padding: 15px; background: #1e293b; border-radius: 5px;">
                    <a href="{{ route('tracks.quizzes.show', [$track, $quiz]) }}" style="color: #04aa6d; text-decoration: none; font-size: 18px; font-weight: 600;">
                        {{ $quiz->title }}
                    </a>
                    @if($quiz->questions_count ?? $quiz->questions->count() ?? 0)
                        <span style="color: #9ca3af; margin-left: 10px;">{{ $quiz->questions_count ?? $quiz->questions->count() }} questions</span>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p style="color: #9ca3af;">No quizzes available yet.</p>
    @endif
</div>
@endsection

