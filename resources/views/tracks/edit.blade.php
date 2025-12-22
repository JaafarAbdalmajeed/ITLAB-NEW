@extends('layouts.app')

@section('title', 'Edit Track - ' . $track->title)
@section('body-class', 'page-track-edit')

@section('content')
<div class="container">
    <h1>Edit Track: {{ $track->title }}</h1>
    <p><a href="{{ route('tracks.show', $track) }}">← Back to Track</a></p>

    <form method="POST" action="{{ route('tracks.update', $track) }}" style="max-width: 800px;">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 20px;">
            <label for="slug" style="display: block; margin-bottom: 5px; font-weight: 600;">Slug</label>
            <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug', $track->slug) }}" required>
            <small style="color: #9ca3af;">URL-friendly identifier (e.g., "html", "css", "js")</small>
            @error('slug')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="title" style="display: block; margin-bottom: 5px; font-weight: 600;">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $track->title) }}" required>
            @error('title')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="description" style="display: block; margin-bottom: 5px; font-weight: 600;">Description</label>
            <textarea id="description" name="description" class="form-control" rows="5">{{ old('description', $track->description) }}</textarea>
            @error('description')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" style="padding: 10px 20px; background: #04aa6d; color: #000; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
            Update Track
        </button>
    </form>
</div>
@endsection

