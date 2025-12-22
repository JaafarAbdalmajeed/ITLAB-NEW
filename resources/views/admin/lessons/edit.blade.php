@extends('admin.layout')

@section('title', 'Edit Lesson')
@section('page-title', 'Edit Lesson: ' . $lesson->title)

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.tracks.lessons.update', [$track, $lesson]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Lesson Title *</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $lesson->title) }}" required>
        </div>

        <div class="form-group">
            <label for="order">Order *</label>
            <input type="number" id="order" name="order" class="form-control" value="{{ old('order', $lesson->order) }}" min="0" required>
        </div>

        <div class="form-group">
            <label for="content">Lesson Content *</label>
            <textarea id="content" name="content" class="form-control" rows="15" required>{{ old('content', $lesson->content) }}</textarea>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
            <a href="{{ route('admin.tracks.lessons.index', $track) }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection

