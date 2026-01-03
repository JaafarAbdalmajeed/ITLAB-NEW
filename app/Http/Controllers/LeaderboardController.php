<?php

namespace App\Http\Controllers;

use App\Services\LeaderboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    public function __construct(
        private LeaderboardService $leaderboardService
    ) {}

    /**
     * Display the leaderboard
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'tracks');
        $period = $request->get('period', 'all');
        $limit = 50; // Top 50 users

        $leaderboard = $this->leaderboardService->getLeaderboard($type, $limit, $period);
        $types = $this->leaderboardService->getLeaderboardTypes();

        // Get current user's stats and rank if authenticated
        $userStats = null;
        $userRank = null;
        if (Auth::check()) {
            $userStats = $this->leaderboardService->getUserStats(Auth::user());
            $userRank = $this->leaderboardService->getUserRank(Auth::user(), $type);
        }

        return view('leaderboard.index', compact(
            'leaderboard',
            'types',
            'type',
            'period',
            'userStats',
            'userRank'
        ));
    }

    /**
     * Get leaderboard data via API
     */
    public function api(Request $request)
    {
        $type = $request->get('type', 'tracks');
        $period = $request->get('period', 'all');
        $limit = (int) $request->get('limit', 50);

        $leaderboard = $this->leaderboardService->getLeaderboard($type, $limit, $period);
        $types = $this->leaderboardService->getLeaderboardTypes();

        return response()->json([
            'success' => true,
            'data' => [
                'leaderboard' => $leaderboard,
                'type' => $type,
                'types' => $types,
            ],
        ]);
    }
}
