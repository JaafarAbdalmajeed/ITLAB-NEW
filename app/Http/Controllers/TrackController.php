<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function index(Request $request)
    {
        $query = Track::query();

        // Filter by minimum rating
        if ($request->has('min_rating')) {
            $minRating = (float) $request->min_rating;
            if ($minRating > 0) {
                $query->withAvg('ratings', 'rating')
                    ->havingRaw('COALESCE(ratings_avg_rating, 0) >= ?', [$minRating]);
            }
        }

        // Sort by rating
        if ($request->has('sort') && $request->sort === 'rating') {
            $direction = $request->get('direction', 'desc');
            $query->orderByRating($direction);
        } else {
            $query->orderBy('title');
        }

        // Filter by minimum ratings count
        if ($request->has('min_ratings_count')) {
            $minCount = (int) $request->min_ratings_count;
            $query->withMinRatingsCount($minCount);
        }

        $tracks = $query->withCount('ratings')->withAvg('ratings', 'rating')->get();

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
    public function show($slug)
{
    // Get track with its videos and lessons using the relationships we defined
    $track = Track::with(['videos', 'lessons' => function($query) {
        $query->orderBy('order');
    }])->where('slug', $slug)->firstOrFail();

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
