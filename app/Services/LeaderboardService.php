<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProgress;
use App\Models\Certificate;
use App\Models\QuizResult;
use App\Models\UserAchievement;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LeaderboardService
{
    /**
     * Get leaderboard by type
     */
    public function getLeaderboard(string $type = 'tracks', int $limit = 100, string $period = 'all'): array
    {
        $cacheKey = "leaderboard:{$type}:{$limit}:{$period}";
        
        // Cache for 1 hour
        return Cache::remember($cacheKey, now()->addHour(), function () use ($type, $limit, $period) {
            return match($type) {
                'tracks' => $this->getTracksLeaderboard($limit),
                'certificates' => $this->getCertificatesLeaderboard($limit),
                'points' => $this->getPointsLeaderboard($limit),
                'quiz_average' => $this->getQuizAverageLeaderboard($limit),
                default => $this->getTracksLeaderboard($limit),
            };
        });
    }

    /**
     * Get leaderboard ranked by completed tracks
     */
    protected function getTracksLeaderboard(int $limit): array
    {
        $users = User::select('users.id', 'users.name', 'users.email')
            ->selectRaw('COUNT(user_progress.id) as completed_tracks')
            ->leftJoin('user_progress', function($join) {
                $join->on('users.id', '=', 'user_progress.user_id')
                     ->where('user_progress.progress_percent', '=', 100);
            })
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('completed_tracks', 'desc')
            ->orderBy('users.name', 'asc')
            ->limit($limit)
            ->get()
            ->map(function ($user, $index) {
                return [
                    'rank' => $index + 1,
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'value' => $user->completed_tracks,
                    'label' => 'Tracks',
                    'icon' => '🏁',
                ];
            });

        return $users->toArray();
    }

    /**
     * Get leaderboard ranked by certificates count
     */
    protected function getCertificatesLeaderboard(int $limit): array
    {
        $users = User::select('users.id', 'users.name', 'users.email')
            ->selectRaw('COUNT(certificates.id) as certificates_count')
            ->leftJoin('certificates', 'users.id', '=', 'certificates.user_id')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('certificates_count', 'desc')
            ->orderBy('users.name', 'asc')
            ->limit($limit)
            ->get()
            ->map(function ($user, $index) {
                return [
                    'rank' => $index + 1,
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'value' => $user->certificates_count,
                    'label' => 'Certificates',
                    'icon' => '🎓',
                ];
            });

        return $users->toArray();
    }

    /**
     * Get leaderboard ranked by achievement points
     */
    protected function getPointsLeaderboard(int $limit): array
    {
        try {
            $users = User::select('users.id', 'users.name', 'users.email')
                ->selectRaw('COALESCE(SUM(achievements.points), 0) as total_points')
                ->leftJoin('user_achievements', 'users.id', '=', 'user_achievements.user_id')
                ->leftJoin('achievements', 'user_achievements.achievement_id', '=', 'achievements.id')
                ->groupBy('users.id', 'users.name', 'users.email')
                ->orderBy('total_points', 'desc')
                ->orderBy('users.name', 'asc')
                ->limit($limit)
                ->get()
                ->map(function ($user, $index) {
                    return [
                        'rank' => $index + 1,
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'value' => (int) $user->total_points,
                        'label' => 'Points',
                        'icon' => '⭐',
                    ];
                });

            return $users->toArray();
        } catch (\Exception $e) {
            // If tables don't exist, return empty array
            return [];
        }
    }

    /**
     * Get leaderboard ranked by quiz average score
     */
    protected function getQuizAverageLeaderboard(int $limit): array
    {
        $users = User::select('users.id', 'users.name', 'users.email')
            ->selectRaw('COALESCE(AVG(quiz_results.score), 0) as average_score')
            ->selectRaw('COUNT(quiz_results.id) as quizzes_taken')
            ->leftJoin('quiz_results', 'users.id', '=', 'quiz_results.user_id')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->having('quizzes_taken', '>', 0)
            ->orderBy('average_score', 'desc')
            ->orderBy('users.name', 'asc')
            ->limit($limit)
            ->get()
            ->map(function ($user, $index) {
                return [
                    'rank' => $index + 1,
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'value' => round((float) $user->average_score, 2),
                    'label' => 'Quiz Average',
                    'icon' => '📊',
                    'quizzes_taken' => $user->quizzes_taken,
                ];
            });

        return $users->toArray();
    }

    /**
     * Get user's rank in a specific leaderboard
     */
    public function getUserRank(User $user, string $type = 'tracks'): ?int
    {
        $leaderboard = $this->getLeaderboard($type, 10000); // Get large limit to find user rank
        
        foreach ($leaderboard as $entry) {
            if ($entry['user_id'] === $user->id) {
                return $entry['rank'];
            }
        }

        return null;
    }

    /**
     * Get user's stats for all leaderboards
     */
    public function getUserStats(User $user): array
    {
        return [
            'tracks' => [
                'value' => UserProgress::where('user_id', $user->id)
                    ->where('progress_percent', 100)
                    ->count(),
                'rank' => $this->getUserRank($user, 'tracks'),
            ],
            'certificates' => [
                'value' => Certificate::where('user_id', $user->id)->count(),
                'rank' => $this->getUserRank($user, 'certificates'),
            ],
            'points' => [
                'value' => $this->getUserPoints($user),
                'rank' => $this->getUserRank($user, 'points'),
            ],
            'quiz_average' => [
                'value' => QuizResult::where('user_id', $user->id)->avg('score') ?? 0,
                'rank' => $this->getUserRank($user, 'quiz_average'),
            ],
        ];
    }

    /**
     * Get user's total points
     */
    protected function getUserPoints(User $user): int
    {
        try {
            return (int) (UserAchievement::where('user_id', $user->id)
                ->join('achievements', 'user_achievements.achievement_id', '=', 'achievements.id')
                ->sum('achievements.points') ?? 0);
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Clear leaderboard cache
     */
    public function clearCache(?string $type = null): void
    {
        if ($type) {
            // Clear specific type cache for common limits
            $limits = [10, 50, 100, 1000];
            foreach ($limits as $limit) {
                Cache::forget("leaderboard:{$type}:{$limit}:all");
            }
        } else {
            // Clear all leaderboard cache
            $keys = ['tracks', 'certificates', 'points', 'quiz_average'];
            $limits = [10, 50, 100, 1000];
            foreach ($keys as $key) {
                foreach ($limits as $limit) {
                    Cache::forget("leaderboard:{$key}:{$limit}:all");
                }
            }
        }
    }

    /**
     * Get all leaderboard types
     */
    public function getLeaderboardTypes(): array
    {
        return [
            'tracks' => [
                'name' => 'Completed Tracks',
                'icon' => '🏁',
                'description' => 'Ranked by number of completed tracks',
            ],
            'certificates' => [
                'name' => 'Certificates',
                'icon' => '🎓',
                'description' => 'Ranked by number of certificates earned',
            ],
            'points' => [
                'name' => 'Achievement Points',
                'icon' => '⭐',
                'description' => 'Ranked by total achievement points',
            ],
            'quiz_average' => [
                'name' => 'Quiz Average',
                'icon' => '📊',
                'description' => 'Ranked by average quiz score',
            ],
        ];
    }
}

