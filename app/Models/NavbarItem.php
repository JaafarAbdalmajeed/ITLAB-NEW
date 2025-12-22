<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavbarItem extends Model
{
    protected $fillable = [
        'label',
        'url',
        'route',
        'icon',
        'order',
        'is_active',
        'target',
        'css_class',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the actual URL for the navbar item
     */
    public function getActualUrlAttribute()
    {
        if ($this->route) {
            try {
                return route($this->route);
            } catch (\Exception $e) {
                return $this->url;
            }
        }
        return $this->url;
    }

    /**
     * Scope to get only active items
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order items
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
