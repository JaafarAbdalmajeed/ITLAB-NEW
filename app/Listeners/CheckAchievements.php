<?php

namespace App\Listeners;

use App\Events\TrackCompleted;
use App\Services\AchievementService;
use Illuminate\Support\Facades\Log;

class CheckAchievements
{
    public function __construct(
        private AchievementService $achievementService
    ) {}

    /**
     * Handle the event.
     */
    public function handle(TrackCompleted $event): void
    {
        $user = $event->user;
        $track = $event->track;

        // Check track-related achievements
        $unlocked = $this->achievementService->checkAchievements($user, 'track_completed', [
            'track' => $track,
        ]);

        // Check daily learning achievements
        $this->achievementService->checkAchievements($user, 'daily_learning');

        if (!empty($unlocked)) {
            Log::info("User {$user->id} unlocked achievements: " . implode(', ', array_map(fn($a) => $a->code, $unlocked)));
        }
    }
}
