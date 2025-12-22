@extends('admin.layout')

@section('title', 'Edit Lab')
@section('page-title', 'Edit Lab: ' . $lab->title)

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.tracks.labs.update', [$track, $lab]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Lab Title *</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $lab->title) }}" required>
        </div>

        <div class="form-group">
            <label for="scenario">Scenario *</label>
            <textarea id="scenario" name="scenario" class="form-control" rows="10" required>{{ old('scenario', $lab->scenario) }}</textarea>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
            <a href="{{ route('admin.tracks.labs.index', $track) }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection

