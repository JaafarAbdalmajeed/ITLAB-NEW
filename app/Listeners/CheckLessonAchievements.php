<?php

namespace App\Listeners;

use App\Events\LessonCompleted;
use App\Services\AchievementService;
use Illuminate\Support\Facades\Log;

class CheckLessonAchievements
{
    public function __construct(
        private AchievementService $achievementService
    ) {}

    /**
     * Handle the event.
     */
    public function handle(LessonCompleted $event): void
    {
        $user = $event->user;

        // Check lesson-related achievements
        $unlocked = $this->achievementService->checkAchievements($user, 'lesson_completed');

        if (!empty($unlocked)) {
            Log::info("User {$user->id} unlocked achievements: " . implode(', ', array_map(fn($a) => $a->code, $unlocked)));
        }
    }
}
