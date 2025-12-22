@extends('admin.layout')

@section('title', 'Add New Quiz')
@section('page-title', 'Add New Quiz - ' . $track->title)

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.tracks.quizzes.store', $track) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Quiz Title *</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save
            </button>
            <a href="{{ route('admin.tracks.quizzes.index', $track) }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection

