@extends('admin.layout')

@section('title', 'Add New Video')
@section('page-title', 'Add New Video - ' . $track->title)

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>Add New Video</h2>
        <a href="{{ route('admin.tracks.videos.index', $track) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Videos
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin: 20px;">
            <ul style="margin: 0; padding-right: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.tracks.videos.store', $track) }}" method="POST" style="padding: 20px;">
        @csrf
        <div class="form-group">
            <label for="title">Video Title *</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
            <small style="color: #666;">e.g., Lesson 1: Introduction to {{ $track->title }}</small>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
            <small style="color: #666;">Optional description for the video</small>
        </div>

        <div class="form-group">
            <label for="video_id">YouTube Video ID or Playlist ID *</label>
            <input type="text" id="video_id" name="video_id" class="form-control" value="{{ old('video_id') }}" placeholder="dQw4w9WgXcQ or PLDoPjvoNmBAwXDFEGst8SUHZuVnS866No">
            <small style="color: #666;">Enter the YouTube video ID (e.g., dQw4w9WgXcQ) or playlist ID (e.g., PLDoPjvoNmBAwXDFEGst8SUHZuVnS866No)</small>
        </div>

        <div class="form-group">
            <label for="url">YouTube URL (Alternative)</label>
            <input type="text" id="url" name="url" class="form-control" value="{{ old('url') }}" placeholder="https://www.youtube.com/watch?v=dQw4w9WgXcQ or https://www.youtube.com/playlist?list=PLp22-4PivYmJfGUFUJUR2IQlv8oI735hE">
            <small style="color: #666;">If you provide a full YouTube URL (video or playlist), the ID will be extracted automatically</small>
        </div>

        <div class="form-group">
            <label for="color">Border Color</label>
            <input type="color" id="color" name="color" class="form-control" value="{{ old('color', '#00ffaa') }}" style="width: 100px; height: 40px;">
            <small style="color: #666;">Color for the video card border (default: #00ffaa)</small>
        </div>

        <div class="form-group">
            <label for="order">Display Order</label>
            @php
                $defaultOrder = 0;
                if (\Illuminate\Support\Facades\Schema::hasColumn('videos', 'order')) {
                    $maxOrder = $track->videos()->max('order');
                    $defaultOrder = $maxOrder ? $maxOrder + 1 : 0;
                }
            @endphp
            <input type="number" id="order" name="order" class="form-control" value="{{ old('order', $defaultOrder) }}" min="0">
            <small style="color: #666;">Lower numbers appear first (default: last position)</small>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Video
            </button>
            <a href="{{ route('admin.tracks.videos.index', $track) }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection

