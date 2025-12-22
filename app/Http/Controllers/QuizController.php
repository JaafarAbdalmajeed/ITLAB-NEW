<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Track;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Track $track)
    {
        $quizzes = $track->quizzes()->get();
        return view('quizzes.index', compact('track', 'quizzes'));
    }

    public function create(Track $track)
    {
        return view('quizzes.create', compact('track'));
    }

    public function store(Request $request, Track $track)
    {
        $data = $request->validate([
            'title' => 'required|string',
        ]);

        $quiz = $track->quizzes()->create($data);

        return redirect()->route('tracks.quizzes.show', [$track, $quiz]);
    }

    public function show(Track $track, Quiz $quiz)
    {
        $quiz->load('questions');
        return view('quizzes.show', compact('track', 'quiz'));
    }

    public function edit(Track $track, Quiz $quiz)
    {
        return view('quizzes.edit', compact('track', 'quiz'));
    }

    public function update(Request $request, Track $track, Quiz $quiz)
    {
        $data = $request->validate([
            'title' => 'required|string',
        ]);

        $quiz->update($data);

        return redirect()->route('tracks.quizzes.show', [$track, $quiz]);
    }

    public function destroy(Track $track, Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('tracks.show', $track);
    }
}
