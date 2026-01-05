<?php

namespace App\Services;

use App\Models\User;
use App\Models\Track;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\Certificate;
use App\Models\UserProgress;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportService
{
    /**
     * Get users report data
     */
    public function getUsersReport(array $filters = []): array
    {
        $query = User::query();

        // Apply filters
        if (isset($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }
        if (isset($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }
        if (isset($filters['is_admin'])) {
            $query->where('is_admin', $filters['is_admin']);
        }

        $users = $query->withCount(['quizResults', 'progress'])
            ->orderBy('created_at', 'desc')
            ->get();

        // User growth over time
        $userGrowth = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Users by registration method
        $usersByProvider = User::select('provider', DB::raw('COUNT(*) as count'))
            ->groupBy('provider')
            ->get();

        return [
            'users' => $users,
            'total_users' => User::count(),
            'admin_users' => User::where('is_admin', true)->count(),
            'regular_users' => User::where('is_admin', false)->count(),
            'user_growth' => $userGrowth,
            'users_by_provider' => $usersByProvider,
        ];
    }

    /**
     * Get tracks report data
     */
    public function getTracksReport(array $filters = []): array
    {
        $query = Track::query();

        // Apply filters
        if (isset($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }
        if (isset($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        $tracks = $query->withCount([
            'lessons',
            'quizzes',
            'labs',
            'userProgress',
            'certificates'
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        // Track completion rates
        $completionRates = [];
        foreach ($tracks as $track) {
            $totalProgress = UserProgress::where('track_id', $track->id)->count();
            $completed = UserProgress::where('track_id', $track->id)
                ->where('progress_percent', 100)
                ->count();
            
            $completionRates[$track->id] = [
                'track' => $track,
                'total_progress' => $totalProgress,
                'completed' => $completed,
                'completion_rate' => $totalProgress > 0 ? round(($completed / $totalProgress) * 100, 2) : 0,
            ];
        }

        // Top performing tracks
        $topTracks = Track::withCount('userProgress')
            ->orderBy('user_progress_count', 'desc')
            ->limit(10)
            ->get();

        return [
            'tracks' => $tracks,
            'total_tracks' => Track::count(),
            'completion_rates' => $completionRates,
            'top_tracks' => $topTracks,
        ];
    }

    /**
     * Get quizzes report data
     */
    public function getQuizzesReport(array $filters = []): array
    {
        $query = Quiz::query();

        // Apply filters
        if (isset($filters['track_id'])) {
            $query->where('track_id', $filters['track_id']);
        }
        if (isset($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }
        if (isset($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        $quizzes = $query->with(['track'])
            ->withCount(['questions', 'results'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Quiz performance statistics
        $quizPerformance = [];
        foreach ($quizzes as $quiz) {
            $results = QuizResult::where('quiz_id', $quiz->id)->get();
            $avgScore = $results->avg('score') ?? 0;
            $maxScore = $results->max('score') ?? 0;
            $minScore = $results->min('score') ?? 0;
            $passCount = $results->where('score', '>=', 70)->count();
            $failCount = $results->where('score', '<', 70)->count();

            $quizPerformance[$quiz->id] = [
                'quiz' => $quiz,
                'total_attempts' => $results->count(),
                'avg_score' => round($avgScore, 2),
                'max_score' => $maxScore,
                'min_score' => $minScore,
                'pass_count' => $passCount,
                'fail_count' => $failCount,
                'pass_rate' => $results->count() > 0 ? round(($passCount / $results->count()) * 100, 2) : 0,
            ];
        }

        // Quiz attempts over time
        $quizAttemptsOverTime = QuizResult::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Average scores by track
        $avgScoresByTrack = QuizResult::select(
            'quizzes.track_id',
            DB::raw('AVG(quiz_results.score) as avg_score'),
            DB::raw('COUNT(*) as attempts')
        )
            ->join('quizzes', 'quiz_results.quiz_id', '=', 'quizzes.id')
            ->groupBy('quizzes.track_id')
            ->get()
            ->map(function ($item) {
                $track = Track::find($item->track_id);
                return [
                    'track' => $track,
                    'avg_score' => round($item->avg_score, 2),
                    'attempts' => $item->attempts,
                ];
            });

        return [
            'quizzes' => $quizzes,
            'total_quizzes' => Quiz::count(),
            'total_attempts' => QuizResult::count(),
            'avg_score' => round(QuizResult::avg('score') ?? 0, 2),
            'quiz_performance' => $quizPerformance,
            'quiz_attempts_over_time' => $quizAttemptsOverTime,
            'avg_scores_by_track' => $avgScoresByTrack,
        ];
    }

    /**
     * Get certificates report data
     */
    public function getCertificatesReport(array $filters = []): array
    {
        $query = Certificate::query();

        // Apply filters
        if (isset($filters['date_from'])) {
            $query->where('issued_at', '>=', $filters['date_from']);
        }
        if (isset($filters['date_to'])) {
            $query->where('issued_at', '<=', $filters['date_to']);
        }
        if (isset($filters['type'])) {
            if ($filters['type'] === 'quiz') {
                $query->whereNotNull('quiz_id');
            } else {
                $query->whereNull('quiz_id');
            }
        }

        $certificates = $query->with(['user', 'track', 'quiz'])
            ->orderBy('issued_at', 'desc')
            ->get();

        // Certificates issued over time
        $certificatesOverTime = Certificate::select(
            DB::raw('DATE(issued_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('issued_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Certificates by type
        $certificatesByType = [
            'track' => Certificate::whereNull('quiz_id')->count(),
            'quiz' => Certificate::whereNotNull('quiz_id')->count(),
        ];

        // Certificates by track
        $certificatesByTrack = Certificate::select(
            'track_id',
            DB::raw('COUNT(*) as count')
        )
            ->whereNotNull('track_id')
            ->groupBy('track_id')
            ->get()
            ->map(function ($item) {
                $track = Track::find($item->track_id);
                return [
                    'track' => $track,
                    'count' => $item->count,
                ];
            });

        // Top certificate earners
        $topEarners = Certificate::select(
            'user_id',
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('user_id')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $user = User::find($item->user_id);
                return [
                    'user' => $user,
                    'count' => $item->count,
                ];
            });

        return [
            'certificates' => $certificates,
            'total_certificates' => Certificate::count(),
            'certificates_over_time' => $certificatesOverTime,
            'certificates_by_type' => $certificatesByType,
            'certificates_by_track' => $certificatesByTrack,
            'top_earners' => $topEarners,
        ];
    }

    /**
     * Get overall dashboard statistics
     */
    public function getDashboardStats(): array
    {
        return [
            'total_users' => User::count(),
            'total_tracks' => Track::count(),
            'total_quizzes' => Quiz::count(),
            'total_certificates' => Certificate::count(),
            'total_quiz_attempts' => QuizResult::count(),
            'avg_quiz_score' => round(QuizResult::avg('score') ?? 0, 2),
            'users_with_progress' => UserProgress::distinct('user_id')->count(),
            'completed_tracks' => UserProgress::where('progress_percent', 100)->count(),
        ];
    }
}

