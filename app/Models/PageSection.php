<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSection extends Model
{
    protected $fillable = [
        'page_id',
        'title',
        'slug',
        'subtitle',
        'content',
        'section_type',
        'metadata',
        'order',
        'published',
    ];

    protected $casts = [
        'metadata' => 'array',
        'published' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the page that owns this section.
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Scope a query to only include published sections.
     */
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    /**
     * Scope a query to order sections by order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
