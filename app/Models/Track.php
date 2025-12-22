<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'tutorial_content',
        'reference_content',
        'videos',
        'hero_content',
        'hero_button_text',
        'hero_button_link',
        'example_code',
        'show_tutorial',
        'show_reference',
        'show_videos',
        'show_labs',
        'show_quiz',
    ];

    protected $casts = [
        'videos' => 'array',
        'show_tutorial' => 'boolean',
        'show_reference' => 'boolean',
        'show_videos' => 'boolean',
        'show_labs' => 'boolean',
        'show_quiz' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function labs()
    {
        return $this->hasMany(Lab::class);
    }

    public function userProgress()
    {
        return $this->hasMany(UserProgress::class);
    }

    /**
     * Scope a query to only include published tracks.
     */
    public function scopePublished($query)
    {
        return $query; // For now, all tracks are published
    }

    /**
     * Get the user's progress for this track
     */
    public function getUserProgress(?int $userId = null): ?UserProgress
    {
        $userId = $userId ?? auth()->id();
        
        if (!$userId) {
            return null;
        }

        return $this->userProgress()
            ->where('user_id', $userId)
            ->first();
    }

    /**
     * Get the main route for this track
     */
    public function getMainRoute(): string
    {
        return \App\Helpers\TrackRouteHelper::getMainRoute($this);
    }

    /**
     * Get the track/lessons route
     */
    public function getTrackRoute(): string
    {
        return \App\Helpers\TrackRouteHelper::getTrackRoute($this);
    }

    /**
     * Get the tutorial route
     */
    public function getTutorialRoute(): string
    {
        return \App\Helpers\TrackRouteHelper::getTutorialRoute($this);
    }

    /**
     * Get the reference route
     */
    public function getReferenceRoute(): string
    {
        return \App\Helpers\TrackRouteHelper::getReferenceRoute($this);
    }

    /**
     * Get the videos route
     */
    public function getVideosRoute(): string
    {
        return \App\Helpers\TrackRouteHelper::getVideosRoute($this);
    }

    /**
     * Get the labs route
     */
    public function getLabsRoute(): string
    {
        return \App\Helpers\TrackRouteHelper::getLabsRoute($this);
    }

    /**
     * Get the quiz route
     */
    public function getQuizRoute(): string
    {
        return \App\Helpers\TrackRouteHelper::getQuizRoute($this);
    }
}
