<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Track $track)
    {
        $quizzes = $track->quizzes()->withCount('questions')->get();
        return view('admin.quizzes.index', compact('track', 'quizzes'));
    }

    public function create(Track $track)
    {
        return view('admin.quizzes.create', compact('track'));
    }

    public function store(Request $request, Track $track)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $track->quizzes()->create($data);

        return redirect()->route('admin.tracks.quizzes.index', $track)
            ->with('success', 'Quiz created successfully.');
    }

    public function show(Track $track, Quiz $quiz)
    {
        $quiz->load('questions');
        return view('admin.quizzes.show', compact('track', 'quiz'));
    }

    public function edit(Track $track, Quiz $quiz)
    {
        return view('admin.quizzes.edit', compact('track', 'quiz'));
    }

    public function update(Request $request, Track $track, Quiz $quiz)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $quiz->update($data);

        return redirect()->route('admin.tracks.quizzes.index', $track)
            ->with('success', 'Quiz updated successfully.');
    }

    public function destroy(Track $track, Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('admin.tracks.quizzes.index', $track)
            ->with('success', 'Quiz deleted successfully.');
    }

    // Question Management
    public function createQuestion(Track $track, Quiz $quiz)
    {
        return view('admin.quizzes.questions.create', compact('track', 'quiz'));
    }

    public function storeQuestion(Request $request, Track $track, Quiz $quiz)
    {
        $data = $request->validate([
            'question' => 'required|string|max:500',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'correct_answer' => 'required|in:a,b,c',
        ]);

        $quiz->questions()->create($data);

        return redirect()->route('admin.tracks.quizzes.show', [$track, $quiz])
            ->with('success', 'Question added successfully.');
    }

    public function editQuestion(Track $track, Quiz $quiz, QuizQuestion $question)
    {
        return view('admin.quizzes.questions.edit', compact('track', 'quiz', 'question'));
    }

    public function updateQuestion(Request $request, Track $track, Quiz $quiz, QuizQuestion $question)
    {
        $data = $request->validate([
            'question' => 'required|string|max:500',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'correct_answer' => 'required|in:a,b,c',
        ]);

        $question->update($data);

        return redirect()->route('admin.tracks.quizzes.show', [$track, $quiz])
            ->with('success', 'Question updated successfully.');
    }

    public function destroyQuestion(Track $track, Quiz $quiz, QuizQuestion $question)
    {
        $question->delete();

        return redirect()->route('admin.tracks.quizzes.show', [$track, $quiz])
            ->with('success', 'Question deleted successfully.');
    }
}

