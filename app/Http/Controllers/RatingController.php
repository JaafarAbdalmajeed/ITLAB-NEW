<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Track;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function __construct()
    {
        // Middleware is applied in routes/web.php
    }

    /**
     * Store or update a rating for a track
     */
    public function storeTrack(Request $request, Track $track)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $user = Auth::user();

        $rating = Rating::updateOrCreate(
            [
                'user_id' => $user->id,
                'track_id' => $track->id,
                'lesson_id' => null,
            ],
            [
                'rating' => $request->rating,
            ]
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Rating saved successfully',
                'rating' => $rating,
                'average' => Rating::getAverageForTrack($track->id),
                'count' => Rating::getCountForTrack($track->id),
            ]);
        }

        return redirect()->back()->with('success', 'Rating saved successfully');
    }

    /**
     * Store or update a rating for a lesson
     */
    public function storeLesson(Request $request, Track $track, Lesson $lesson)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $user = Auth::user();

        $rating = Rating::updateOrCreate(
            [
                'user_id' => $user->id,
                'track_id' => null,
                'lesson_id' => $lesson->id,
            ],
            [
                'rating' => $request->rating,
            ]
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Rating saved successfully',
                'rating' => $rating,
                'average' => Rating::getAverageForLesson($lesson->id),
                'count' => Rating::getCountForLesson($lesson->id),
            ]);
        }

        return redirect()->back()->with('success', 'Rating saved successfully');
    }

    /**
     * Get rating statistics for a track
     */
    public function showTrack(Track $track)
    {
        $userRating = null;
        if (Auth::check()) {
            $userRating = Rating::where('user_id', Auth::id())
                ->where('track_id', $track->id)
                ->first();
        }

        try {
            $stats = [
                'average' => Rating::getAverageForTrack($track->id),
                'count' => Rating::getCountForTrack($track->id),
                'user_rating' => $userRating?->rating,
                'distribution' => $this->getRatingDistribution($track->id, 'track'),
            ];
        } catch (\Exception $e) {
            // If ratings table doesn't exist, return empty stats
            $stats = [
                'average' => 0,
                'count' => 0,
                'user_rating' => null,
                'distribution' => [],
            ];
        }

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $stats,
            ]);
        }

        return $stats;
    }

    /**
     * Get rating distribution
     */
    protected function getRatingDistribution($id, $type = 'track'): array
    {
        $query = $type === 'track' 
            ? Rating::where('track_id', $id)
            : Rating::where('lesson_id', $id);

        $total = $query->count();
        
        $distribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = (clone $query)->where('rating', $i)->count();
            $distribution[$i] = [
                'count' => $count,
                'percentage' => $total > 0 ? round(($count / $total) * 100, 1) : 0,
            ];
        }

        return $distribution;
    }
}
