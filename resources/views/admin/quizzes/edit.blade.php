@extends('admin.layout')

@section('title', 'Edit Quiz')
@section('page-title', 'Edit Quiz: ' . $quiz->title)

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.tracks.quizzes.update', [$track, $quiz]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Quiz Title *</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $quiz->title) }}" required>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
            <a href="{{ route('admin.tracks.quizzes.index', $track) }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection

