<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Track;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Track $track)
    {
        $lessons = $track->lessons()->orderBy('order')->get();
        return view('lessons.index', compact('track', 'lessons'));
    }

    public function create(Track $track)
    {
        return view('lessons.create', compact('track'));
    }

    public function store(Request $request, Track $track)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'order' => 'integer',
        ]);

        $lesson = $track->lessons()->create($data);

        return redirect()->route('tracks.lessons.show', [$track, $lesson]);
    }

    public function show(Track $track, Lesson $lesson)
    {
        // Load track with lessons ordered for navigation
        $track->load(['lessons' => function($query) {
            $query->orderBy('order');
        }]);
        return view('lessons.show', compact('track', 'lesson'));
    }

    public function edit(Track $track, Lesson $lesson)
    {
        return view('lessons.edit', compact('track', 'lesson'));
    }

    public function update(Request $request, Track $track, Lesson $lesson)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'order' => 'integer',
        ]);

        $lesson->update($data);

        return redirect()->route('tracks.lessons.show', [$track, $lesson]);
    }

    public function destroy(Track $track, Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('tracks.show', $track);
    }
}
