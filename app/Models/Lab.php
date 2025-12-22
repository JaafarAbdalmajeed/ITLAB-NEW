<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;

    protected $fillable = [
        'track_id',
        'title',
        'scenario',
    ];

    public function track()
    {
        return $this->belongsTo(Track::class);
    }
}
