<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    use HasFactory;

    protected $table = 'user_progress';

    protected $fillable = [
        'user_id',
        'track_id',
        'progress_percent',
    ];

    protected $casts = [
        'progress_percent' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    /**
     * Check if progress is completed (100%)
     */
    public function isCompleted(): bool
    {
        return $this->progress_percent >= 100;
    }
}
