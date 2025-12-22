@extends('admin.layout')

@section('title', 'Manage Quizzes')
@section('page-title', 'Quizzes: ' . $track->title)

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>All Quizzes</h2>
        <div>
            <a href="{{ route('admin.tracks.index') }}" class="btn btn-secondary" style="margin-left: 10px;">
                <i class="fas fa-arrow-right"></i> Back to Tracks
            </a>
            <a href="{{ route('admin.tracks.quizzes.create', $track) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Quiz
            </a>
        </div>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Questions Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($quizzes as $quiz)
                <tr>
                    <td><strong>{{ $quiz->title }}</strong></td>
                    <td>{{ $quiz->questions_count }}</td>
                    <td>
                        <a href="{{ route('admin.tracks.quizzes.show', [$track, $quiz]) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px; margin-left: 5px;">
                            <i class="fas fa-eye"></i> View Questions
                        </a>
                        <a href="{{ route('admin.tracks.quizzes.edit', [$track, $quiz]) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px; margin-left: 5px;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.tracks.quizzes.destroy', [$track, $quiz]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;" onclick="return confirm('Are you sure you want to delete this quiz?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">No quizzes found. <a href="{{ route('admin.tracks.quizzes.create', $track) }}">Add a new quiz</a></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

