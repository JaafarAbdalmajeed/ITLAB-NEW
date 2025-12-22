@extends('admin.layout')

@section('title', 'Add New Lesson')
@section('page-title', 'Add New Lesson - ' . $track->title)

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.tracks.lessons.store', $track) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Lesson Title *</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="order">Order *</label>
            <input type="number" id="order" name="order" class="form-control" value="{{ old('order', 0) }}" min="0" required>
            <small style="color: #666;">The order in which the lesson will appear in the track</small>
        </div>

        <div class="form-group">
            <label for="content">Lesson Content *</label>
            <textarea id="content" name="content" class="form-control" rows="15" required>{{ old('content') }}</textarea>
            <small style="color: #666;">You can use HTML in the content</small>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save
            </button>
            <a href="{{ route('admin.tracks.lessons.index', $track) }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection

