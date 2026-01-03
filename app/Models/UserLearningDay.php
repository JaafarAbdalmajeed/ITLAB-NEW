<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserLearningDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'learning_date',
    ];

    protected $casts = [
        'learning_date' => 'date',
    ];

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Record a learning day for a user
     */
    public static function recordLearningDay(User $user, ?Carbon $date = null): self
    {
        $date = $date ?? Carbon::today();

        return self::firstOrCreate([
            'user_id' => $user->id,
            'learning_date' => $date->format('Y-m-d'),
        ]);
    }

    /**
     * Get consecutive learning days for a user
     */
    public static function getConsecutiveDays(User $user): int
    {
        $today = Carbon::today();
        $consecutiveDays = 0;
        $checkDate = $today->copy();

        // Check backwards from today
        while (true) {
            $exists = self::where('user_id', $user->id)
                ->where('learning_date', $checkDate->format('Y-m-d'))
                ->exists();

            if (!$exists) {
                break;
            }

            $consecutiveDays++;
            $checkDate->subDay();
        }

        return $consecutiveDays;
    }

    /**
     * Check if user learned today
     */
    public static function learnedToday(User $user): bool
    {
        return self::where('user_id', $user->id)
            ->where('learning_date', Carbon::today()->format('Y-m-d'))
            ->exists();
    }
}
