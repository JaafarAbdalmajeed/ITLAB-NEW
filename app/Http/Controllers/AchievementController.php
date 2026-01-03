<?php

namespace App\Http\Controllers;

use App\Services\AchievementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    public function __construct(
        private AchievementService $achievementService
    ) {
        // Middleware is applied in routes/web.php
    }

    /**
     * Display all achievements for the authenticated user
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $data = $this->achievementService->getUserAchievements($user);
            $progress = $this->achievementService->getUserProgress($user);

            return view('achievements.index', compact('data', 'progress'));
        } catch (\Exception $e) {
            // If tables don't exist yet, return empty data
            return view('achievements.index', [
                'data' => [
                    'all' => collect([]),
                    'unlocked' => [],
                    'locked' => collect([]),
                    'stats' => [
                        'total' => 0,
                        'unlocked' => 0,
                        'locked' => 0,
                        'percentage' => 0,
                    ],
                ],
                'progress' => [
                    'total_points' => 0,
                    'achievements_count' => 0,
                    'recent_achievements' => [],
                ],
            ]);
        }
    }

    /**
     * Display user's achievement progress (API endpoint)
     */
    public function progress()
    {
        $user = Auth::user();
        $progress = $this->achievementService->getUserProgress($user);
        $data = $this->achievementService->getUserAchievements($user);

        return response()->json([
            'success' => true,
            'data' => [
                'progress' => $progress,
                'achievements' => $data,
            ],
        ]);
    }

    /**
     * Get recent achievements (for dashboard widget)
     */
    public function recent()
    {
        $user = Auth::user();
        $progress = $this->achievementService->getUserProgress($user);

        return response()->json([
            'success' => true,
            'data' => $progress['recent_achievements'] ?? [],
        ]);
    }
}
