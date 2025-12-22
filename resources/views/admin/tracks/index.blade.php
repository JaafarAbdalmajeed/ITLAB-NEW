@extends('admin.layout')

@section('title', 'Manage Tracks')
@section('page-title', 'Manage Tracks')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>All Tracks</h2>
        <a href="{{ route('admin.tracks.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Track
        </a>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Lessons</th>
                <th>Quizzes</th>
                <th>Labs</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tracks as $track)
                <tr>
                    <td><strong>{{ $track->title }}</strong></td>
                    <td><code>{{ $track->slug }}</code></td>
                    <td>{{ \Illuminate\Support\Str::limit($track->description, 50) }}</td>
                    <td>{{ $track->lessons_count }}</td>
                    <td>{{ $track->quizzes_count }}</td>
                    <td>{{ $track->labs_count }}</td>
                    <td>
                        <a href="{{ route('admin.tracks.lessons.index', $track) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px; margin-left: 5px;">
                            <i class="fas fa-book"></i> Lessons
                        </a>
                        <a href="{{ route('admin.tracks.quizzes.index', $track) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px; margin-left: 5px;">
                            <i class="fas fa-question-circle"></i> Quizzes
                        </a>
                        <a href="{{ route('admin.tracks.labs.index', $track) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px; margin-left: 5px;">
                            <i class="fas fa-flask"></i> Labs
                        </a>
                        <a href="{{ route('admin.tracks.edit', $track) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px; margin-left: 5px;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.tracks.destroy', $track) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;" onclick="return confirm('Are you sure you want to delete this track?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">No tracks found. <a href="{{ route('admin.tracks.create') }}">Add a new track</a></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

