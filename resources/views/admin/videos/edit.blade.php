@extends('admin.layout')

@section('title', 'Edit Video')
@section('page-title', 'Edit Video - ' . $track->title)

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>Edit Video</h2>
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

    <form action="{{ route('admin.tracks.videos.update', [$track, $video]) }}" method="POST" style="padding: 20px;">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Video Title *</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $video->title) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $video->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="video_id">YouTube Video ID or Playlist ID</label>
            <input type="text" id="video_id" name="video_id" class="form-control" value="{{ old('video_id', $video->video_id) }}" placeholder="dQw4w9WgXcQ or PLDoPjvoNmBAwXDFEGst8SUHZuVnS866No">
        </div>

        <div class="form-group">
            <label for="url">YouTube URL (Alternative)</label>
            <input type="text" id="url" name="url" class="form-control" value="{{ old('url', $video->url) }}" placeholder="https://www.youtube.com/watch?v=dQw4w9WgXcQ">
        </div>

        <div class="form-group">
            <label for="color">Border Color</label>
            <input type="color" id="color" name="color" class="form-control" value="{{ old('color', $video->color) }}" style="width: 100px; height: 40px;">
        </div>

        <div class="form-group">
            <label for="order">Display Order</label>
            <input type="number" id="order" name="order" class="form-control" value="{{ old('order', $video->order) }}" min="0">
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Video
            </button>
            <a href="{{ route('admin.tracks.videos.index', $track) }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection

