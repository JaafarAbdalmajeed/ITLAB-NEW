@extends('layouts.app')

@section('title', 'Edit Lesson - ' . $lesson->title)
@section('body-class', 'page-lesson-edit')

@section('content')
<div class="container">
    <h1>Edit Lesson: {{ $lesson->title }}</h1>
    <p><a href="{{ route('tracks.lessons.show', [$track, $lesson]) }}">← Back to Lesson</a></p>

    <form method="POST" action="{{ route('tracks.lessons.update', [$track, $lesson]) }}" style="max-width: 800px;">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 20px;">
            <label for="title" style="display: block; margin-bottom: 5px; font-weight: 600;">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $lesson->title) }}" required>
            @error('title')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="content" style="display: block; margin-bottom: 5px; font-weight: 600;">Content</label>
            <textarea id="content" name="content" class="form-control" rows="15" required>{{ old('content', $lesson->content) }}</textarea>
            @error('content')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="order" style="display: block; margin-bottom: 5px; font-weight: 600;">Order</label>
            <input type="number" id="order" name="order" class="form-control" value="{{ old('order', $lesson->order) }}">
            @error('order')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" style="padding: 10px 20px; background: #04aa6d; color: #000; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
            Update Lesson
        </button>
    </form>
</div>
@endsection

