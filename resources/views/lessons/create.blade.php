@extends('layouts.app')

@section('title', 'Create Lesson - ' . $track->title)
@section('body-class', 'page-lesson-create')

@section('content')
<div class="container">
    <h1>Create New Lesson for {{ $track->title }}</h1>
    <p><a href="{{ route('tracks.lessons.index', $track) }}">← Back to Lessons</a></p>

    <form method="POST" action="{{ route('tracks.lessons.store', $track) }}" style="max-width: 800px;">
        @csrf
        
        <div style="margin-bottom: 20px;">
            <label for="title" style="display: block; margin-bottom: 5px; font-weight: 600;">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
            @error('title')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="content" style="display: block; margin-bottom: 5px; font-weight: 600;">Content</label>
            <textarea id="content" name="content" class="form-control" rows="15" required>{{ old('content') }}</textarea>
            @error('content')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="order" style="display: block; margin-bottom: 5px; font-weight: 600;">Order</label>
            <input type="number" id="order" name="order" class="form-control" value="{{ old('order', $track->lessons()->count() + 1) }}">
            @error('order')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" style="padding: 10px 20px; background: #04aa6d; color: #000; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
            Create Lesson
        </button>
    </form>
</div>
@endsection

