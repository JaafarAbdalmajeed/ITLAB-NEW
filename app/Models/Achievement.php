<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'icon',
        'badge_color',
        'type',
        'criteria',
        'points',
        'is_active',
        'order',
    ];

    protected $casts = [
        'criteria' => 'array',
        'is_active' => 'boolean',
        'points' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Get all users who have this achievement
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_achievements')
            ->withPivot('unlocked_at')
            ->withTimestamps();
    }

    /**
     * Check if a user has this achievement
     */
    public function isUnlockedBy(User $user): bool
    {
        return $this->users()->where('user_id', $user->id)->exists();
    }

    /**
     * Get display name (prefer English if available)
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->name_en ?: $this->name_ar ?: $this->code;
    }

    /**
     * Get display description (prefer English if available)
     */
    public function getDisplayDescriptionAttribute(): string
    {
        return $this->description_en ?: $this->description_ar ?: '';
    }

    /**
     * Scope active achievements
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by type
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }
}
