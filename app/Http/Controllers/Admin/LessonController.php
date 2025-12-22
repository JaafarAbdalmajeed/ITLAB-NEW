<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Track $track)
    {
        $lessons = $track->lessons()->orderBy('order')->get();
        return view('admin.lessons.index', compact('track', 'lessons'));
    }

    public function create(Track $track)
    {
        return view('admin.lessons.create', compact('track'));
    }

    public function store(Request $request, Track $track)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'required|integer|min:0',
        ]);

        $track->lessons()->create($data);

        return redirect()->route('admin.tracks.lessons.index', $track)
            ->with('success', 'Lesson created successfully.');
    }

    public function edit(Track $track, Lesson $lesson)
    {
        return view('admin.lessons.edit', compact('track', 'lesson'));
    }

    public function update(Request $request, Track $track, Lesson $lesson)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'required|integer|min:0',
        ]);

        $lesson->update($data);

        return redirect()->route('admin.tracks.lessons.index', $track)
            ->with('success', 'Lesson updated successfully.');
    }

    public function destroy(Track $track, Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('admin.tracks.lessons.index', $track)
            ->with('success', 'Lesson deleted successfully.');
    }
}

