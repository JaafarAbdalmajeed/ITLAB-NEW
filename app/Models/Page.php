<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    protected $fillable = ['slug', 'title', 'meta_description', 'content', 'published'];

    protected $casts = [
        'published' => 'boolean',
    ];

    /**
     * Get all sections for this page.
     */
    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class)->ordered();
    }

    /**
     * Get published sections for this page.
     */
    public function publishedSections(): HasMany
    {
        return $this->hasMany(PageSection::class)->published()->ordered();
    }
}
