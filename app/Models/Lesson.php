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
    ];

    public function track()
    {
        return $this->belongsTo(Track::class);
    }
}
