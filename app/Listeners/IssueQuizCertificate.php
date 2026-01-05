<?php

namespace App\Listeners;

use App\Events\QuizSubmitted;
use App\Models\Certificate;
use Illuminate\Support\Facades\Log;

class IssueQuizCertificate
{
    /**
     * Handle the event.
     * Issue a certificate if user scores 70% or higher on a quiz
     */
    public function handle(QuizSubmitted $event): void
    {
        $result = $event->result;
        $quiz = $result->quiz;
        $user = $result->user;
        $score = $result->score;

        // Only issue certificate if score is 70% or higher
        if ($score < 70) {
            return;
        }

        // Check if certificate already exists for this user and quiz
        $existingCertificate = Certificate::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->first();

        if ($existingCertificate) {
            Log::info("Certificate already exists for user {$user->id} on quiz {$quiz->id}");
            return;
        }

        // Create certificate for quiz
        try {
            $certificate = Certificate::create([
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
                'track_id' => null, // Quiz certificates don't require track completion
                'certificate_number' => Certificate::generateCertificateNumber(),
                'issued_at' => now(),
            ]);

            Log::info("Certificate issued for user {$user->id} on quiz {$quiz->id} with score {$score}%");
        } catch (\Exception $e) {
            Log::error("Failed to issue certificate for user {$user->id} on quiz {$quiz->id}: " . $e->getMessage());
        }
    }
}
