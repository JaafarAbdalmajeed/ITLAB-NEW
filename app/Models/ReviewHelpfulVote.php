<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewHelpfulVote extends Model
{
    use HasFactory;

    protected $table = 'review_helpful_votes';

    protected $fillable = [
        'review_id',
        'user_id',
        'is_helpful',
    ];

    protected $casts = [
        'is_helpful' => 'boolean',
    ];

    /**
     * Get the review
     */
    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    /**
     * Get the user who voted
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
