<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserProgressRequest;
use App\Models\Track;
use App\Services\ProgressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserProgressController extends Controller
{
    protected $progressService;

    public function __construct(ProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    public function update(UpdateUserProgressRequest $request, Track $track)
    {
        try {
            $userId = $request->input('user_id');
            $progressPercent = $request->input('progress_percent');

            $user = \App\Models\User::findOrFail($userId);

            // Check authorization
            if (auth()->id() != $userId && !auth()->user()->is_admin) {
                return response()->json([
                    'error' => 'You are not authorized to update this user\'s progress'
                ], 403);
            }

            $progress = $this->progressService->updateProgress($user, $track, $progressPercent);

            return response()->json([
                'success' => true,
                'progress' => $progress,
                'message' => 'Progress updated successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Progress update error: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'An error occurred while updating progress'
            ], 500);
        }
    }

    /**
     * Get user's progress for a track
     */
    public function show(Track $track)
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json([
                'error' => 'You must be logged in'
            ], 401);
        }

        $progress = \App\Models\UserProgress::where('user_id', $user->id)
            ->where('track_id', $track->id)
            ->first();

        $calculatedProgress = $this->progressService->calculateProgress($user, $track);

        return response()->json([
            'progress' => $progress,
            'calculated_progress' => $calculatedProgress,
        ]);
    }

    /**
     * Get overall progress for authenticated user
     */
    public function overall()
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json([
                'error' => 'You must be logged in'
            ], 401);
        }

        $overallProgress = $this->progressService->getOverallProgress($user);

        return response()->json($overallProgress);
    }
}
