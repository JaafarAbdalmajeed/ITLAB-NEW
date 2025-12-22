@extends('layouts.app')

@section('title', 'Create Quiz - ' . $track->title)
@section('body-class', 'page-quiz-create')

@section('content')
<div class="container">
    <h1>Create New Quiz for {{ $track->title }}</h1>
    <p><a href="{{ route('tracks.quizzes.index', $track) }}">← Back to Quizzes</a></p>

    <form method="POST" action="{{ route('tracks.quizzes.store', $track) }}" style="max-width: 800px;">
        @csrf
        
        <div style="margin-bottom: 20px;">
            <label for="title" style="display: block; margin-bottom: 5px; font-weight: 600;">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
            @error('title')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" style="padding: 10px 20px; background: #04aa6d; color: #000; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
            Create Quiz
        </button>
    </form>
</div>
@endsection

