@extends('layouts.app')

@section('title', 'Edit Quiz - ' . $quiz->title)
@section('body-class', 'page-quiz-edit')

@section('content')
<div class="container">
    <h1>Edit Quiz: {{ $quiz->title }}</h1>
    <p><a href="{{ route('tracks.quizzes.show', [$track, $quiz]) }}">← Back to Quiz</a></p>

    <form method="POST" action="{{ route('tracks.quizzes.update', [$track, $quiz]) }}" style="max-width: 800px;">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 20px;">
            <label for="title" style="display: block; margin-bottom: 5px; font-weight: 600;">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $quiz->title) }}" required>
            @error('title')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" style="padding: 10px 20px; background: #04aa6d; color: #000; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
            Update Quiz
        </button>
    </form>
</div>
@endsection

