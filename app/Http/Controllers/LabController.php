<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\Track;
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function index(Track $track)
    {
        $labs = $track->labs()->get();
        return view('labs.index', compact('track', 'labs'));
    }

    public function create(Track $track)
    {
        return view('labs.create', compact('track'));
    }

    public function store(Request $request, Track $track)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'scenario' => 'nullable|string',
        ]);

        $lab = $track->labs()->create($data);

        return redirect()->route('tracks.labs.show', [$track, $lab]);
    }

    public function show(Track $track, Lab $lab)
    {
        return view('labs.show', compact('track', 'lab'));
    }

    public function edit(Track $track, Lab $lab)
    {
        return view('labs.edit', compact('track', 'lab'));
    }

    public function update(Request $request, Track $track, Lab $lab)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'scenario' => 'nullable|string',
        ]);

        $lab->update($data);

        return redirect()->route('tracks.labs.show', [$track, $lab]);
    }

    public function destroy(Track $track, Lab $lab)
    {
        $lab->delete();
        return redirect()->route('tracks.show', $track);
    }
}
