<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Lab;
use App\Models\User;
use App\Models\QuizResult;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        // Basic Statistics
        $stats = [
            'tracks' => Track::count(),
            'lessons' => Lesson::count(),
            'quizzes' => Quiz::count(),
            'labs' => Lab::count(),
            'users' => User::count(),
            'quiz_results' => QuizResult::count(),
        ];

        // Advanced Statistics
        $advancedStats = [
            'total_quiz_attempts' => QuizResult::count(),
            'average_quiz_score' => round(QuizResult::avg('score') ?? 0, 2),
            'users_with_progress' => UserProgress::distinct('user_id')->count(),
            'completed_tracks' => UserProgress::where('progress_percent', 100)->count(),
            'total_progress_records' => UserProgress::count(),
        ];

        // Top Performing Tracks
        $topTracks = Track::withCount(['userProgress', 'lessons', 'quizzes'])
            ->orderBy('user_progress_count', 'desc')
            ->limit(10)
            ->get();

        // Recent Activity
        $recentQuizResults = QuizResult::with(['user', 'quiz.track'])
            ->latest()
            ->limit(10)
            ->get();

        // User Growth (Last 30 days)
        $userGrowth = User::where('created_at', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Quiz Performance by Track
        $quizPerformance = QuizResult::select('quizzes.track_id', DB::raw('AVG(quiz_results.score) as avg_score'), DB::raw('COUNT(*) as attempts'))
            ->join('quizzes', 'quiz_results.quiz_id', '=', 'quizzes.id')
            ->join('tracks', 'quizzes.track_id', '=', 'tracks.id')
            ->groupBy('quizzes.track_id')
            ->get()
            ->map(function($item) {
                $track = Track::find($item->track_id);
                return (object)[
                    'track_id' => $item->track_id,
                    'avg_score' => $item->avg_score,
                    'attempts' => $item->attempts,
                    'track' => $track
                ];
            });

        return view('admin.stats.index', compact(
            'stats',
            'advancedStats',
            'topTracks',
            'recentQuizResults',
            'userGrowth',
            'quizPerformance'
        ));
    }
}

