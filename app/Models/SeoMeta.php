<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeoMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'seoable_id',
        'seoable_type',
        'page_path',
        'route_name',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
        'robots',
        'structured_data'
    ];

    protected $casts = [
        'structured_data' => 'array'
    ];

    /**
     * Get the parent seoable model (Product or Category).
     */
    public function seoable()
    {
        return $this->morphTo();
    }
}
