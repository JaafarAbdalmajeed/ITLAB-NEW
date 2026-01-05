<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'track_id',
        'title',
        'description',
        'url',
        'video_id',
        'color',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Get the track that owns the video.
     */
    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    /**
     * Get the YouTube embed URL
     */
    public function getEmbedUrlAttribute(): string
    {
        if ($this->video_id) {
            // Check if it's a playlist ID (starts with PL)
            if (strpos($this->video_id, 'PL') === 0) {
                return "https://www.youtube.com/embed/videoseries?list={$this->video_id}";
            }
            // Regular video ID
            return "https://www.youtube.com/embed/{$this->video_id}";
        }
        
        // Fallback to URL if video_id is not set
        if ($this->url) {
            // Extract playlist ID first
            if (preg_match('/[?&]list=([a-zA-Z0-9_-]+)/', $this->url, $matches)) {
                return "https://www.youtube.com/embed/videoseries?list={$matches[1]}";
            }
            // Extract video ID from YouTube URL if it's a full URL
            if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $this->url, $matches)) {
                return "https://www.youtube.com/embed/{$matches[1]}";
            }
            return $this->url;
        }
        
        return '';
    }

    /**
     * Get the YouTube watch URL
     */
    public function getWatchUrlAttribute(): string
    {
        if ($this->video_id) {
            return "https://youtube.com/watch?v={$this->video_id}";
        }
        
        if ($this->url) {
            return $this->url;
        }
        
        return '';
    }
}
