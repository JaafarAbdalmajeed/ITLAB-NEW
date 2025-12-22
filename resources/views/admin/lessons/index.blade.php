@extends('admin.layout')

@section('title', 'Manage Lessons')
@section('page-title', 'Lessons: ' . $track->title)

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>All Lessons</h2>
        <div>
            <a href="{{ route('admin.tracks.index') }}" class="btn btn-secondary" style="margin-left: 10px;">
                <i class="fas fa-arrow-right"></i> Back to Tracks
            </a>
            <a href="{{ route('admin.tracks.lessons.create', $track) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Lesson
            </a>
        </div>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Order</th>
                <th>Title</th>
                <th>Content</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lessons as $lesson)
                <tr>
                    <td>{{ $lesson->order }}</td>
                    <td><strong>{{ $lesson->title }}</strong></td>
                    <td>{{ \Illuminate\Support\Str::limit(strip_tags($lesson->content), 100) }}</td>
                    <td>
                        <a href="{{ route('admin.tracks.lessons.edit', [$track, $lesson]) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px; margin-left: 5px;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.tracks.lessons.destroy', [$track, $lesson]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;" onclick="return confirm('Are you sure you want to delete this lesson?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No lessons found. <a href="{{ route('admin.tracks.lessons.create', $track) }}">Add a new lesson</a></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

