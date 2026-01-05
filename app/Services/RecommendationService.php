<?php

namespace App\Services;

use App\Models\Track;
use App\Models\User;
use App\Models\UserProgress;
use App\Models\QuizResult;
use Illuminate\Support\Facades\DB;

class RecommendationService
{
    /**
     * Get personalized recommendations for a user
     */
    public function getRecommendations(?User $user = null, int $limit = 6): array
    {
        if (!$user) {
            return $this->getDefaultRecommendations($limit);
        }

        $recommendations = [];

        // 1. Recommendations based on completed tracks
        $completedBased = $this->getRecommendationsBasedOnCompleted($user, $limit);
        $recommendations = array_merge($recommendations, $completedBased);

        // 2. Recommendations based on current progress
        $progressBased = $this->getRecommendationsBasedOnProgress($user, $limit);
        $recommendations = array_merge($recommendations, $progressBased);

        // 3. Recommendations based on skill level
        $levelBased = $this->getRecommendationsBasedOnLevel($user, $limit);
        $recommendations = array_merge($recommendations, $levelBased);

        // 4. Popular tracks (fallback)
        $popular = $this->getPopularTracks($limit);
        $recommendations = array_merge($recommendations, $popular);

        // Remove duplicates and tracks user already completed
        $completedTrackIds = $user->progress()
            ->where('progress_percent', 100)
            ->pluck('track_id')
            ->toArray();

        $uniqueRecommendations = [];
        $seenTrackIds = [];

        foreach ($recommendations as $track) {
            $trackId = is_array($track) ? ($track['id'] ?? null) : $track->id;
            if ($trackId && !in_array($trackId, $completedTrackIds) && !in_array($trackId, $seenTrackIds)) {
                $uniqueRecommendations[] = is_array($track) ? Track::find($trackId) : $track;
                $seenTrackIds[] = $trackId;
            }
        }

        // Filter out null values
        $uniqueRecommendations = array_filter($uniqueRecommendations);

        return array_slice($uniqueRecommendations, 0, $limit);
    }

    /**
     * Get recommendations based on completed tracks
     */
    protected function getRecommendationsBasedOnCompleted(User $user, int $limit): array
    {
        $completedTracks = $user->progress()
            ->where('progress_percent', 100)
            ->with('track')
            ->get()
            ->pluck('track')
            ->filter();

        if ($completedTracks->isEmpty()) {
            return [];
        }

        // Find tracks that are similar or related to completed tracks
        $completedSlugs = $completedTracks->pluck('slug')->toArray();
        $completedIds = $completedTracks->pluck('id')->toArray();
        
        // Get tracks that share similar characteristics
        $query = Track::whereNotIn('id', $completedIds);
        
        if (!empty($completedSlugs)) {
            $query->where(function ($q) use ($completedSlugs) {
                // Find tracks in similar categories
                foreach ($completedSlugs as $slug) {
                    if (str_contains($slug, 'cyber')) {
                        $q->orWhere('slug', 'like', 'cyber%');
                    } elseif (in_array($slug, ['html', 'css', 'js'])) {
                        $q->orWhereIn('slug', ['html', 'css', 'js', 'java']);
                    }
                }
            });
        }
        
        $recommendations = $query->withCount('userProgress')
            ->orderBy('user_progress_count', 'desc')
            ->limit($limit)
            ->get();

        return $recommendations->all();
    }

    /**
     * Get recommendations based on current progress
     */
    protected function getRecommendationsBasedOnProgress(User $user, int $limit): array
    {
        $inProgressTracks = $user->progress()
            ->where('progress_percent', '>', 0)
            ->where('progress_percent', '<', 100)
            ->with('track')
            ->orderBy('progress_percent', 'desc')
            ->get()
            ->pluck('track')
            ->filter();

        if ($inProgressTracks->isEmpty()) {
            return [];
        }

        // Recommend tracks that complement the ones in progress
        $inProgressIds = $inProgressTracks->pluck('id')->toArray();
        
        $recommendations = Track::whereNotIn('id', $inProgressIds)
            ->withCount('userProgress')
            ->orderBy('user_progress_count', 'desc')
            ->limit($limit)
            ->get();

        return $recommendations->all();
    }

    /**
     * Get recommendations based on user skill level
     */
    protected function getRecommendationsBasedOnLevel(User $user, int $limit): array
    {
        // Calculate user skill level based on completed tracks and quiz scores
        $completedCount = $user->progress()
            ->where('progress_percent', 100)
            ->count();

        $avgQuizScore = QuizResult::where('user_id', $user->id)
            ->avg('score') ?? 0;

        // Determine skill level
        $skillLevel = 'beginner';
        if ($completedCount >= 5 && $avgQuizScore >= 80) {
            $skillLevel = 'advanced';
        } elseif ($completedCount >= 2 || $avgQuizScore >= 70) {
            $skillLevel = 'intermediate';
        }

        // Recommend tracks based on skill level
        $query = Track::query();

        if ($skillLevel === 'beginner') {
            // Beginner-friendly tracks
            $query->where(function($q) {
                $q->whereIn('slug', ['html', 'css', 'js'])
                  ->orWhere('slug', 'like', 'cyber%');
            });
        } elseif ($skillLevel === 'intermediate') {
            // Intermediate tracks
            $query->where(function($q) {
                $q->whereIn('slug', ['js', 'java'])
                  ->orWhere('slug', 'like', 'cyber%');
            });
        } else {
            // Advanced tracks - all tracks
            $query->orderBy('created_at', 'desc');
        }

        return $query->withCount('userProgress')
            ->orderBy('user_progress_count', 'desc')
            ->limit($limit)
            ->get()
            ->all();
    }

    /**
     * Get popular tracks
     */
    protected function getPopularTracks(int $limit): array
    {
        return Track::withCount('userProgress')
            ->orderBy('user_progress_count', 'desc')
            ->limit($limit)
            ->get()
            ->all();
    }

    /**
     * Get default recommendations for guests
     */
    protected function getDefaultRecommendations(int $limit): array
    {
        return Track::withCount('userProgress')
            ->orderBy('user_progress_count', 'desc')
            ->limit($limit)
            ->get()
            ->all();
    }

    /**
     * Get "You might also like" recommendations
     */
    public function getYouMightAlsoLike(?User $user = null, Track $currentTrack, int $limit = 4): array
    {
        if (!$user) {
            return $this->getSimilarTracks($currentTrack, $limit);
        }

        $recommendations = [];

        // Get tracks similar to current track
        $similar = $this->getSimilarTracks($currentTrack, $limit * 2);
        $recommendations = array_merge($recommendations, $similar);

        // Get tracks based on user's completed tracks
        $userBased = $this->getRecommendationsBasedOnCompleted($user, $limit);
        $recommendations = array_merge($recommendations, $userBased);

        // Remove current track and duplicates
        $uniqueRecommendations = [];
        $seenTrackIds = [$currentTrack->id];

        foreach ($recommendations as $track) {
            $trackId = is_array($track) ? ($track['id'] ?? null) : $track->id;
            if ($trackId && !in_array($trackId, $seenTrackIds)) {
                $uniqueRecommendations[] = is_array($track) ? Track::find($trackId) : $track;
                $seenTrackIds[] = $trackId;
            }
        }

        // Filter out null values
        $uniqueRecommendations = array_filter($uniqueRecommendations);

        return array_slice($uniqueRecommendations, 0, $limit);
    }

    /**
     * Get similar tracks based on category or tags
     */
    protected function getSimilarTracks(Track $track, int $limit): array
    {
        $slug = $track->slug;
        
        $query = Track::where('id', '!=', $track->id);

        // Find similar tracks based on slug patterns
        if (str_contains($slug, 'cyber')) {
            $query->where('slug', 'like', 'cyber%');
        } elseif (in_array($slug, ['html', 'css', 'js'])) {
            $query->whereIn('slug', ['html', 'css', 'js']);
        } elseif ($slug === 'java') {
            $query->where('slug', 'java');
        }

        return $query->withCount('userProgress')
            ->orderBy('user_progress_count', 'desc')
            ->limit($limit)
            ->get()
            ->all();
    }

    /**
     * Get recommendations based on interests (if we had interest tracking)
     */
    public function getRecommendationsBasedOnInterests(User $user, int $limit): array
    {
        // This can be extended if we add interest tracking
        // For now, use completed tracks as a proxy for interests
        return $this->getRecommendationsBasedOnCompleted($user, $limit);
    }
}

