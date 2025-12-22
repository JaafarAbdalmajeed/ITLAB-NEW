<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Models\Lab;
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function index(Track $track)
    {
        $labs = $track->labs()->latest()->get();
        return view('admin.labs.index', compact('track', 'labs'));
    }

    public function create(Track $track)
    {
        return view('admin.labs.create', compact('track'));
    }

    public function store(Request $request, Track $track)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'scenario' => 'required|string',
        ]);

        $track->labs()->create($data);

        return redirect()->route('admin.tracks.labs.index', $track)
            ->with('success', 'Lab created successfully.');
    }

    public function edit(Track $track, Lab $lab)
    {
        return view('admin.labs.edit', compact('track', 'lab'));
    }

    public function update(Request $request, Track $track, Lab $lab)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'scenario' => 'required|string',
        ]);

        $lab->update($data);

        return redirect()->route('admin.tracks.labs.index', $track)
            ->with('success', 'Lab updated successfully.');
    }

    public function destroy(Track $track, Lab $lab)
    {
        $lab->delete();

        return redirect()->route('admin.tracks.labs.index', $track)
            ->with('success', 'Lab deleted successfully.');
    }
}

