@extends('admin.layout')

@section('title', 'Edit Question')
@section('page-title', 'Edit Question')

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.tracks.quizzes.questions.update', [$track, $quiz, $question]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="question">Question *</label>
            <textarea id="question" name="question" class="form-control" rows="3" required>{{ old('question', $question->question) }}</textarea>
        </div>

        <div class="form-group">
            <label for="option_a">Option A *</label>
            <input type="text" id="option_a" name="option_a" class="form-control" value="{{ old('option_a', $question->option_a) }}" required>
        </div>

        <div class="form-group">
            <label for="option_b">Option B *</label>
            <input type="text" id="option_b" name="option_b" class="form-control" value="{{ old('option_b', $question->option_b) }}" required>
        </div>

        <div class="form-group">
            <label for="option_c">Option C *</label>
            <input type="text" id="option_c" name="option_c" class="form-control" value="{{ old('option_c', $question->option_c) }}" required>
        </div>

        <div class="form-group">
            <label for="correct_answer">Correct Answer *</label>
            <select id="correct_answer" name="correct_answer" class="form-control" required>
                <option value="a" {{ old('correct_answer', $question->correct_answer) == 'a' ? 'selected' : '' }}>A</option>
                <option value="b" {{ old('correct_answer', $question->correct_answer) == 'b' ? 'selected' : '' }}>B</option>
                <option value="c" {{ old('correct_answer', $question->correct_answer) == 'c' ? 'selected' : '' }}>C</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
            <a href="{{ route('admin.tracks.quizzes.show', [$track, $quiz]) }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection

