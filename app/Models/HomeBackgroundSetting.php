<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeBackgroundSetting extends Model
{
    protected $fillable = [
        'type',
        'image_path',
        'video_path',
        'animated_type',
        'is_active',
        'overlay_color',
        'overlay_opacity',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'overlay_opacity' => 'integer',
    ];

    /**
     * Get the active background setting
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }
}
