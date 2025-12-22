<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'message',
        'subject',
        'phone',
        'read',
        'read_at',
        'read_by',
        'admin_notes',
    ];

    protected $casts = [
        'read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user who read this contact message
     */
    public function readByUser()
    {
        return $this->belongsTo(User::class, 'read_by');
    }

    /**
     * Mark message as read
     */
    public function markAsRead(?int $userId = null)
    {
        $this->update([
            'read' => true,
            'read_at' => now(),
            'read_by' => $userId ?? auth()->id(),
        ]);
    }

    /**
     * Mark message as unread
     */
    public function markAsUnread()
    {
        $this->update([
            'read' => false,
            'read_at' => null,
            'read_by' => null,
        ]);
    }

    /**
     * Scope a query to only include unread messages.
     */
    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }

    /**
     * Scope a query to only include read messages.
     */
    public function scopeRead($query)
    {
        return $query->where('read', true);
    }

    /**
     * Scope a query to order by newest first.
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}

