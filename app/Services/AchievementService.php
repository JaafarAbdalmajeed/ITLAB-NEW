<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\User;
use App\Models\UserAchievement;
use App\Models\UserLearningDay;
use App\Models\UserProgress;
use App\Models\QuizResult;
use Illuminate\Support\Facades\Log;

class AchievementService
{
    /**
     * Unlock an achievement for a user
     */
    public function unlockAchievement(User $user, Achievement $achievement): ?UserAchievement
    {
        // Check if already unlocked
        if ($this->hasAchievement($user, $achievement)) {
            return null;
        }

        // Create user achievement
        $userAchievement = UserAchievement::create([
            'user_id' => $user->id,
            'achievement_id' => $achievement->id,
            'unlocked_at' => now(),
        ]);

        Log::info("Achievement unlocked: User {$user->id} unlocked achievement {$achievement->code}");

        // Clear leaderboard cache for points
        try {
            app(\App\Services\LeaderboardService::class)->clearCache('points');
        } catch (\Exception $e) {
            // Ignore if LeaderboardService is not available
        }

        return $userAchievement;
    }

    /**
     * Check if user has an achievement
     */
    public function hasAchievement(User $user, Achievement $achievement): bool
    {
        return UserAchievement::where('user_id', $user->id)
            ->where('achievement_id', $achievement->id)
            ->exists();
    }

    /**
     * Check and unlock achievements based on user actions
     */
    public function checkAchievements(User $user, string $action, array $data = []): array
    {
        $unlocked = [];

        switch ($action) {
            case 'lesson_completed':
                $unlocked = $this->checkLessonAchievements($user);
                break;

            case 'track_completed':
                $unlocked = $this->checkTrackAchievements($user, $data['track'] ?? null);
                break;

            case 'quiz_completed':
                $unlocked = $this->checkQuizAchievements($user, $data['quiz_result'] ?? null);
                break;

            case 'daily_learning':
                $unlocked = $this->checkDailyLearningAchievements($user);
                break;
        }

        return $unlocked;
    }

    /**
     * Check lesson-related achievements
     */
    protected function checkLessonAchievements(User $user): array
    {
        $unlocked = [];

        // Record learning day
        UserLearningDay::recordLearningDay($user);

        // Check "First Lesson" achievement
        $firstLesson = Achievement::where('code', 'first_lesson')->first();
        if ($firstLesson && !$this->hasAchievement($user, $firstLesson)) {
            // Check if user has completed at least one lesson
            // Since we don't have a lesson completion tracking, we'll check progress
            $hasProgress = UserProgress::where('user_id', $user->id)->exists();
            if ($hasProgress) {
                $ua = $this->unlockAchievement($user, $firstLesson);
                if ($ua) {
                    $unlocked[] = $firstLesson;
                }
            }
        }

        // Check daily learning achievements (this should be checked whenever user learns)
        $dailyUnlocked = $this->checkDailyLearningAchievementsInternal($user);
        $unlocked = array_merge($unlocked, $dailyUnlocked);

        return $unlocked;
    }

    /**
     * Check track-related achievements
     */
    protected function checkTrackAchievements(User $user, $track = null): array
    {
        $unlocked = [];

        // Check "First Track" achievement
        $firstTrack = Achievement::where('code', 'first_track')->first();
        if ($firstTrack && !$this->hasAchievement($user, $firstTrack)) {
            $completedTracks = UserProgress::where('user_id', $user->id)
                ->where('progress_percent', 100)
                ->count();

            if ($completedTracks >= 1) {
                $ua = $this->unlockAchievement($user, $firstTrack);
                if ($ua) {
                    $unlocked[] = $firstTrack;
                }
            }
        }

        // Check "Five Tracks" achievement
        $fiveTracks = Achievement::where('code', 'five_tracks')->first();
        if ($fiveTracks && !$this->hasAchievement($user, $fiveTracks)) {
            $completedTracks = UserProgress::where('user_id', $user->id)
                ->where('progress_percent', 100)
                ->count();

            if ($completedTracks >= 5) {
                $ua = $this->unlockAchievement($user, $fiveTracks);
                if ($ua) {
                    $unlocked[] = $fiveTracks;
                }
            }
        }

        // Check "Expert" achievement (all tracks completed)
        $expert = Achievement::where('code', 'expert')->first();
        if ($expert && !$this->hasAchievement($user, $expert)) {
            $totalTracks = \App\Models\Track::count();
            $completedTracks = UserProgress::where('user_id', $user->id)
                ->where('progress_percent', 100)
                ->count();

            if ($totalTracks > 0 && $completedTracks >= $totalTracks) {
                $ua = $this->unlockAchievement($user, $expert);
                if ($ua) {
                    $unlocked[] = $expert;
                }
            }
        }

        return $unlocked;
    }

    /**
     * Check quiz-related achievements
     */
    protected function checkQuizAchievements(User $user, $quizResult = null): array
    {
        $unlocked = [];

        if (!$quizResult) {
            return $unlocked;
        }

        // Check "Perfect Quiz" achievement (100% score)
        $perfectQuiz = Achievement::where('code', 'perfect_quiz')->first();
        if ($perfectQuiz && !$this->hasAchievement($user, $perfectQuiz)) {
            if ($quizResult->score >= 100) {
                $ua = $this->unlockAchievement($user, $perfectQuiz);
                if ($ua) {
                    $unlocked[] = $perfectQuiz;
                }
            }
        }

        return $unlocked;
    }

    /**
     * Check daily learning achievements (public method)
     */
    protected function checkDailyLearningAchievements(User $user): array
    {
        // Record learning day
        UserLearningDay::recordLearningDay($user);
        
        return $this->checkDailyLearningAchievementsInternal($user);
    }

    /**
     * Check daily learning achievements (internal, without recording)
     */
    protected function checkDailyLearningAchievementsInternal(User $user): array
    {
        $unlocked = [];

        // Check "Active Learner" achievement (7 consecutive days)
        $activeLearner = Achievement::where('code', 'active_learner')->first();
        if ($activeLearner && !$this->hasAchievement($user, $activeLearner)) {
            $consecutiveDays = UserLearningDay::getConsecutiveDays($user);
            
            if ($consecutiveDays >= 7) {
                $ua = $this->unlockAchievement($user, $activeLearner);
                if ($ua) {
                    $unlocked[] = $activeLearner;
                }
            }
        }

        return $unlocked;
    }

    /**
     * Get all achievements for a user
     */
    public function getUserAchievements(User $user): array
    {
        $allAchievements = Achievement::active()->orderBy('order')->get();
        $unlockedAchievementIds = UserAchievement::where('user_id', $user->id)
            ->pluck('achievement_id')
            ->toArray();

        return [
            'all' => $allAchievements,
            'unlocked' => $unlockedAchievementIds,
            'locked' => $allAchievements->filter(fn($a) => !in_array($a->id, $unlockedAchievementIds)),
            'stats' => [
                'total' => $allAchievements->count(),
                'unlocked' => count($unlockedAchievementIds),
                'locked' => $allAchievements->count() - count($unlockedAchievementIds),
                'percentage' => $allAchievements->count() > 0 
                    ? round((count($unlockedAchievementIds) / $allAchievements->count()) * 100, 2)
                    : 0,
            ],
        ];
    }

    /**
     * Get user's achievement progress
     */
    public function getUserProgress(User $user): array
    {
        $stats = [
            'total_points' => 0,
            'achievements_count' => 0,
            'recent_achievements' => [],
        ];

        $userAchievements = UserAchievement::where('user_id', $user->id)
            ->with('achievement')
            ->orderBy('unlocked_at', 'desc')
            ->get();

        foreach ($userAchievements as $ua) {
            $stats['total_points'] += $ua->achievement->points ?? 0;
            $stats['achievements_count']++;
        }

        $stats['recent_achievements'] = $userAchievements->take(5)->map(function ($ua) {
            return [
                'id' => $ua->achievement->id,
                'code' => $ua->achievement->code,
                'name' => $ua->achievement->display_name,
                'description' => $ua->achievement->display_description,
                'icon' => $ua->achievement->icon,
                'badge_color' => $ua->achievement->badge_color,
                'unlocked_at' => $ua->unlocked_at->format('Y-m-d H:i:s'),
            ];
        })->toArray();

        return $stats;
    }
}

