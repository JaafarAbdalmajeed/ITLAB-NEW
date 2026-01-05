<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'provider',
        'provider_id',
        'avatar',
        'preferences',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'preferences' => 'array',
        ];
    }

    public function quizResults()
    {
        return $this->hasMany(\App\Models\QuizResult::class);
    }

    public function progress()
    {
        return $this->hasMany(\App\Models\UserProgress::class);
    }

    public function certificates()
    {
        return $this->hasMany(\App\Models\Certificate::class);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')
            ->withPivot('unlocked_at')
            ->withTimestamps();
    }

    public function userAchievements()
    {
        return $this->hasMany(UserAchievement::class);
    }

    public function learningDays()
    {
        return $this->hasMany(UserLearningDay::class);
    }

    /**
     * Get user preference value
     */
    public function getPreference(string $key, $default = null)
    {
        $preferences = $this->preferences ?? [];
        return $preferences[$key] ?? $default;
    }

    /**
     * Set user preference
     */
    public function setPreference(string $key, $value): void
    {
        $preferences = $this->preferences ?? [];
        $preferences[$key] = $value;
        $this->preferences = $preferences;
        $this->save();
    }

    /**
     * Get all preferences with defaults
     */
    public function getPreferences(): array
    {
        $defaults = [
            'theme' => 'light',
            'primary_color' => '#04aa6d',
            'font_size' => 'medium',
            'language' => 'en',
            'layout' => 'default',
        ];

        $preferences = $this->preferences ?? [];
        return array_merge($defaults, $preferences);
    }
}
