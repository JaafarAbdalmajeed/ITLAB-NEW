<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function index()
    {
        $tracks = Track::orderBy('title')->get();
        return view('tracks.index', compact('tracks'));
    }

    public function create()
    {
        return view('tracks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slug' => 'required|unique:tracks,slug',
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $track = Track::create($data);

        return redirect()->route('tracks.show', $track);
    }

    public function show(Track $track)
    {
        $track->load(['lessons' => function($query) {
            $query->orderBy('order');
        }, 'quizzes', 'labs']);
        return view('tracks.show', compact('track'));
    }

    public function edit(Track $track)
    {
        return view('tracks.edit', compact('track'));
    }

    public function update(Request $request, Track $track)
    {
        $data = $request->validate([
            'slug' => 'required|unique:tracks,slug,' . $track->id,
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $track->update($data);

        return redirect()->route('tracks.show', $track);
    }

    public function destroy(Track $track)
    {
        $track->delete();
        return redirect()->route('tracks.index');
    }
}
