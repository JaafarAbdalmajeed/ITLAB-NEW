<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewHelpfulVote;
use App\Models\Track;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        // Middleware is applied in routes/web.php
    }

    /**
     * Get reviews for a track
     */
    public function indexTrack(Request $request, Track $track)
    {
        $query = Review::forTrack($track->id)
            ->approved()
            ->with(['user', 'helpfulVotes'])
            ->withCount(['helpfulVotes as helpful_count' => function ($q) {
                $q->where('is_helpful', true);
            }]);

        // Sort by most helpful or newest
        $sort = $request->get('sort', 'helpful');
        if ($sort === 'newest') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('helpful_count', 'desc')
                  ->orderBy('created_at', 'desc');
        }

        if ($request->expectsJson()) {
            $reviews = $query->paginate(10);
            return response()->json([
                'success' => true,
                'data' => $reviews,
            ]);
        }

        $reviews = $query->get();
        return $reviews;
    }

    /**
     * Store a review for a track
     */
    public function storeTrack(Request $request, Track $track)
    {
        $request->validate([
            'review' => 'required|string|min:10|max:1000',
        ]);

        $user = Auth::user();

        // Check if user already reviewed
        $existingReview = Review::where('user_id', $user->id)
            ->where('track_id', $track->id)
            ->first();

        if ($existingReview) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already reviewed this track',
                ], 422);
            }
            return redirect()->back()->with('error', 'You have already reviewed this track');
        }

        $review = Review::create([
            'user_id' => $user->id,
            'track_id' => $track->id,
            'lesson_id' => null,
            'review' => $request->review,
            'is_approved' => true, // Auto-approve for now
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Review submitted successfully',
                'review' => $review->load('user'),
            ]);
        }

        return redirect()->back()->with('success', 'Review submitted successfully');
    }

    /**
     * Vote on a review
     */
    public function vote(Request $request, Review $review)
    {
        $request->validate([
            'is_helpful' => 'required|boolean',
        ]);

        $user = Auth::user();

        // Check if user already voted
        $existingVote = ReviewHelpfulVote::where('review_id', $review->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingVote) {
            // Update existing vote
            $existingVote->update(['is_helpful' => $request->is_helpful]);
            $vote = $existingVote;
        } else {
            // Create new vote
            $vote = ReviewHelpfulVote::create([
                'review_id' => $review->id,
                'user_id' => $user->id,
                'is_helpful' => $request->is_helpful,
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Vote saved successfully',
                'vote' => $vote,
                'helpful_count' => $review->fresh()->helpful_count,
                'not_helpful_count' => $review->fresh()->not_helpful_count,
            ]);
        }

        return redirect()->back()->with('success', 'Vote saved successfully');
    }

    /**
     * Delete a review
     */
    public function destroy(Review $review)
    {
        $user = Auth::user();

        // Only allow user to delete their own review
        if ($review->user_id !== $user->id && !$user->is_admin) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 403);
            }
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $review->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Review deleted successfully',
            ]);
        }

        return redirect()->back()->with('success', 'Review deleted successfully');
    }
}
