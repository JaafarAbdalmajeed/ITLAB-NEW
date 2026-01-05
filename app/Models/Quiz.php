<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'track_id',
        'title',
    ];

    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function results()
    {
        return $this->hasMany(QuizResult::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function calculateScore(array $answers): int
    {
        $questions = $this->questions()->get();
        $correct = 0;
        foreach ($questions as $question) {
            if (isset($answers[$question->id]) && $answers[$question->id] === $question->correct_answer) {
                $correct++;
            }
        }

        return (int) round(($correct / max(1, $questions->count())) * 100);
    }

    /**
     * Get user's best result for this quiz
     */
    public function getUserBestResult(?int $userId = null): ?QuizResult
    {
        $userId = $userId ?? auth()->id();
        
        if (!$userId) {
            return null;
        }

        return $this->results()
            ->where('user_id', $userId)
            ->orderBy('score', 'desc')
            ->first();
    }

    /**
     * Check if user has completed this quiz
     */
    public function isCompletedByUser(?int $userId = null): bool
    {
        $userId = $userId ?? auth()->id();
        
        if (!$userId) {
            return false;
        }

        return $this->results()
            ->where('user_id', $userId)
            ->exists();
    }
}
