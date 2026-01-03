<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'track_id',
        'lesson_id',
        'review',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * Get the user that owns the review
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the track being reviewed
     */
    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    /**
     * Get the lesson being reviewed
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Get helpful votes for this review
     */
    public function helpfulVotes()
    {
        return $this->hasMany(ReviewHelpfulVote::class);
    }

    /**
     * Get helpful votes count
     */
    public function getHelpfulCountAttribute(): int
    {
        return $this->helpfulVotes()->where('is_helpful', true)->count();
    }

    /**
     * Get not helpful votes count
     */
    public function getNotHelpfulCountAttribute(): int
    {
        return $this->helpfulVotes()->where('is_helpful', false)->count();
    }

    /**
     * Check if user has voted on this review
     */
    public function hasUserVoted(?int $userId = null): bool
    {
        if (!$userId) {
            $userId = auth()->id();
        }

        if (!$userId) {
            return false;
        }

        return $this->helpfulVotes()->where('user_id', $userId)->exists();
    }

    /**
     * Scope reviews for a specific track
     */
    public function scopeForTrack($query, $trackId)
    {
        return $query->where('track_id', $trackId);
    }

    /**
     * Scope reviews for a specific lesson
     */
    public function scopeForLesson($query, $lessonId)
    {
        return $query->where('lesson_id', $lessonId);
    }

    /**
     * Scope approved reviews
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope reviews with helpful votes
     */
    public function scopeMostHelpful($query)
    {
        return $query->withCount(['helpfulVotes as helpful_count' => function ($q) {
            $q->where('is_helpful', true);
        }])->orderBy('helpful_count', 'desc');
    }
}
