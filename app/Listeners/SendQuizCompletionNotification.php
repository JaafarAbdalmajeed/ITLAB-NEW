<?php

namespace App\Listeners;

use App\Events\QuizSubmitted;
use Illuminate\Support\Facades\Log;

class SendQuizCompletionNotification
{
    /**
     * Handle the event.
     */
    public function handle(QuizSubmitted $event): void
    {
        $result = $event->result;
        $user = $result->user;
        $quiz = $result->quiz;

        Log::info("Quiz completed: User {$user->id} scored {$result->score}% on quiz {$quiz->id}");

        // Here you could send email notifications, update achievements, etc.
        // For now, we'll just log it
    }
}

