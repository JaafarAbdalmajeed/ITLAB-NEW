@extends('admin.layout')

@section('title', 'Quiz Questions')
@section('page-title', 'Questions: ' . $quiz->title)

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>Quiz Questions</h2>
        <div>
            <a href="{{ route('admin.tracks.quizzes.index', $track) }}" class="btn btn-secondary" style="margin-left: 10px;">
                <i class="fas fa-arrow-right"></i> Back to Quizzes
            </a>
            <a href="{{ route('admin.tracks.quizzes.questions.create', [$track, $quiz]) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Question
            </a>
        </div>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Question</th>
                <th>Option A</th>
                <th>Option B</th>
                <th>Option C</th>
                <th>Correct Answer</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($quiz->questions as $question)
                <tr>
                    <td><strong>{{ $question->question }}</strong></td>
                    <td>{{ $question->option_a }}</td>
                    <td>{{ $question->option_b }}</td>
                    <td>{{ $question->option_c }}</td>
                    <td>
                        <span style="background: var(--admin-secondary); color: #000; padding: 3px 8px; border-radius: 3px; font-weight: bold;">
                            {{ strtoupper($question->correct_answer) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.tracks.quizzes.questions.edit', [$track, $quiz, $question]) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px; margin-left: 5px;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.tracks.quizzes.questions.destroy', [$track, $quiz, $question]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;" onclick="return confirm('Are you sure you want to delete this question?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">No questions found. <a href="{{ route('admin.tracks.quizzes.questions.create', [$track, $quiz]) }}">Add a new question</a></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

