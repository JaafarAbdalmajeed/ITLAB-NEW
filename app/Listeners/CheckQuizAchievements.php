<?php

namespace App\Listeners;

use App\Events\QuizSubmitted;
use App\Services\AchievementService;
use Illuminate\Support\Facades\Log;

class CheckQuizAchievements
{
    public function __construct(
        private AchievementService $achievementService
    ) {}

    /**
     * Handle the event.
     */
    public function handle(QuizSubmitted $event): void
    {
        $result = $event->result;
        $user = $result->user;

        // Check quiz-related achievements
        $unlocked = $this->achievementService->checkAchievements($user, 'quiz_completed', [
            'quiz_result' => $result,
        ]);

        // Check daily learning achievements
        $this->achievementService->checkAchievements($user, 'daily_learning');

        if (!empty($unlocked)) {
            Log::info("User {$user->id} unlocked achievements: " . implode(', ', array_map(fn($a) => $a->code, $unlocked)));
        }
    }
}
