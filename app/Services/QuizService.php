<?php

namespace App\Services;

use App\Events\QuizSubmitted;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class QuizService
{
    /**
     * Calculate quiz score and save result
     */
    public function submitQuiz(Quiz $quiz, array $answers, ?User $user = null): array
    {
        $user = $user ?? auth()->user();
        
        if (!$user) {
            throw new \Exception('User must be authenticated to submit quiz');
        }

        $score = $quiz->calculateScore($answers);
        
        // Check if user already submitted this quiz
        $existingResult = QuizResult::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->first();

        if ($existingResult) {
            // Update existing result if new score is higher
            if ($score > $existingResult->score) {
                $existingResult->update(['score' => $score]);
                Log::info("Quiz result updated for user {$user->id}, quiz {$quiz->id}, new score: {$score}");
            }
            
            return [
                'result' => $existingResult->fresh(),
                'score' => $score,
                'is_new_record' => false,
            ];
        }

        $result = QuizResult::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'score' => $score,
        ]);

        Log::info("Quiz result created for user {$user->id}, quiz {$quiz->id}, score: {$score}");

        // Fire event
        event(new QuizSubmitted($result));

        return [
            'result' => $result,
            'score' => $score,
            'is_new_record' => true,
        ];
    }

    /**
     * Get user's best score for a quiz
     */
    public function getUserBestScore(Quiz $quiz, User $user): ?QuizResult
    {
        $result = QuizResult::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->orderBy('score', 'desc')
            ->first();

        return $result;
    }

    /**
     * Get quiz statistics
     */
    public function getQuizStatistics(Quiz $quiz): array
    {
        $results = QuizResult::where('quiz_id', $quiz->id)->get();
        
        if ($results->isEmpty()) {
            return [
                'total_attempts' => 0,
                'average_score' => 0,
                'highest_score' => 0,
                'lowest_score' => 0,
            ];
        }

        return [
            'total_attempts' => $results->count(),
            'average_score' => round($results->avg('score'), 2),
            'highest_score' => $results->max('score'),
            'lowest_score' => $results->min('score'),
        ];
    }
}

