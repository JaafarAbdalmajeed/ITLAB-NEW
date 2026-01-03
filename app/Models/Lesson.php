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
}
