<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'track_id',
        'lesson_id',
        'rating',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Get the user that owns the rating
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the track being rated
     */
    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    /**
     * Get the lesson being rated
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Scope ratings for a specific track
     */
    public function scopeForTrack($query, $trackId)
    {
        return $query->where('track_id', $trackId);
    }

    /**
     * Scope ratings for a specific lesson
     */
    public function scopeForLesson($query, $lessonId)
    {
        return $query->where('lesson_id', $lessonId);
    }

    /**
     * Get average rating for a track
     */
    public static function getAverageForTrack($trackId): float
    {
        return (float) static::forTrack($trackId)->avg('rating') ?? 0;
    }

    /**
     * Get average rating for a lesson
     */
    public static function getAverageForLesson($lessonId): float
    {
        return (float) static::forLesson($lessonId)->avg('rating') ?? 0;
    }

    /**
     * Get rating count for a track
     */
    public static function getCountForTrack($trackId): int
    {
        return static::forTrack($trackId)->count();
    }

    /**
     * Get rating count for a lesson
     */
    public static function getCountForLesson($lessonId): int
    {
        return static::forLesson($lessonId)->count();
    }
}
