<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'track_id',
        'title',
        'content',
        'order',
        'youtube_videos',
        'sections',
        'enable_code_editor',
    ];

    protected $casts = [
        'youtube_videos' => 'array',
        'sections' => 'array',
        'enable_code_editor' => 'boolean',
    ];

    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function userProgress()
    {
        return $this->hasMany(UserLessonProgress::class);
    }

    /**
     * Check if lesson is completed by user
     */
    public function isCompletedByUser(?int $userId): bool
    {
        if (!$userId) {
            return false;
        }

        return UserLessonProgress::isLessonCompleted($userId, $this->id);
    }

    /**
     * Get average rating for this lesson
     */
    public function getAverageRatingAttribute(): float
    {
        return Rating::getAverageForLesson($this->id);
    }

    /**
     * Get rating count for this lesson
     */
    public function getRatingCountAttribute(): int
    {
        return Rating::getCountForLesson($this->id);
    }
}
