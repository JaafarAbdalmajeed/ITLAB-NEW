@extends('admin.layout')

@section('title', 'Add New Question')
@section('page-title', 'Add New Question - ' . $quiz->title)

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.tracks.quizzes.questions.store', [$track, $quiz]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="question">Question *</label>
            <textarea id="question" name="question" class="form-control" rows="3" required>{{ old('question') }}</textarea>
        </div>

        <div class="form-group">
            <label for="option_a">Option A *</label>
            <input type="text" id="option_a" name="option_a" class="form-control" value="{{ old('option_a') }}" required>
        </div>

        <div class="form-group">
            <label for="option_b">Option B *</label>
            <input type="text" id="option_b" name="option_b" class="form-control" value="{{ old('option_b') }}" required>
        </div>

        <div class="form-group">
            <label for="option_c">Option C *</label>
            <input type="text" id="option_c" name="option_c" class="form-control" value="{{ old('option_c') }}" required>
        </div>

        <div class="form-group">
            <label for="correct_answer">Correct Answer *</label>
            <select id="correct_answer" name="correct_answer" class="form-control" required>
                <option value="">Select correct answer</option>
                <option value="a" {{ old('correct_answer') == 'a' ? 'selected' : '' }}>A</option>
                <option value="b" {{ old('correct_answer') == 'b' ? 'selected' : '' }}>B</option>
                <option value="c" {{ old('correct_answer') == 'c' ? 'selected' : '' }}>C</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save
            </button>
            <a href="{{ route('admin.tracks.quizzes.show', [$track, $quiz]) }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection

