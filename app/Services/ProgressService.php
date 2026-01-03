<?php

namespace App\Services;

use App\Events\TrackCompleted;
use App\Events\LessonCompleted;
use App\Models\Track;
use App\Models\Lesson;
use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProgressService
{
    /**
     * Update or create user progress for a track
     */
    public function updateProgress(User $user, Track $track, int $progressPercent, ?Lesson $lesson = null): UserProgress
    {
        $wasNew = !UserProgress::where('user_id', $user->id)
            ->where('track_id', $track->id)
            ->exists();

        $progress = UserProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'track_id' => $track->id,
            ],
            [
                'progress_percent' => min(100, max(0, $progressPercent)),
            ]
        );

        Log::info("Progress updated for user {$user->id}, track {$track->id}, progress: {$progressPercent}%");

        // If this is the first time user has progress on this track, trigger lesson completion
        if ($wasNew && $lesson) {
            event(new LessonCompleted($user, $lesson));
        }

        return $progress;
    }

    /**
     * Calculate progress based on completed lessons, quizzes, and labs
     */
    public function calculateProgress(User $user, Track $track): int
    {
        $totalItems = 0;
        $completedItems = 0;

        // Count lessons
        $lessonsCount = $track->lessons()->count();
        $totalItems += $lessonsCount;

        // Count quizzes
        $quizzesCount = $track->quizzes()->count();
        $totalItems += $quizzesCount;

        // Count labs
        $labsCount = $track->labs()->count();
        $totalItems += $labsCount;

        if ($totalItems === 0) {
            return 0;
        }

        // For now, we'll use a simple calculation
        // In a real app, you'd track which lessons/quizzes/labs are completed
        $progress = UserProgress::where('user_id', $user->id)
            ->where('track_id', $track->id)
            ->first();

        return $progress ? $progress->progress_percent : 0;
    }

    /**
     * Get user's overall progress across all tracks
     */
    public function getOverallProgress(User $user): array
    {
        $tracks = Track::all();
        $totalProgress = 0;
        $tracksWithProgress = 0;

        foreach ($tracks as $track) {
            $progress = UserProgress::where('user_id', $user->id)
                ->where('track_id', $track->id)
                ->first();

            if ($progress) {
                $totalProgress += $progress->progress_percent;
                $tracksWithProgress++;
            }
        }

        $averageProgress = $tracksWithProgress > 0 
            ? round($totalProgress / $tracksWithProgress, 2) 
            : 0;

        return [
            'average_progress' => $averageProgress,
            'tracks_completed' => UserProgress::where('user_id', $user->id)
                ->where('progress_percent', 100)
                ->count(),
            'total_tracks' => $tracks->count(),
        ];
    }

    /**
     * Mark track as completed
     */
    public function markTrackCompleted(User $user, Track $track): void
    {
        $this->updateProgress($user, $track, 100);
        Log::info("Track {$track->id} marked as completed for user {$user->id}");
        
        // Clear leaderboard cache
        try {
            $leaderboardService = app(\App\Services\LeaderboardService::class);
            $leaderboardService->clearCache('tracks');
            $leaderboardService->clearCache('certificates');
        } catch (\Exception $e) {
            // Ignore if LeaderboardService is not available
        }
        
        // Fire event
        event(new TrackCompleted($user, $track));
    }
}

