<?php

namespace App\Traits;

use App\Models\SeoMeta;

trait HasSeo
{
    /**
     * Get the model's SEO metadata.
     */
    public function seoMeta()
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    /**
     * Helper to get SEO data for the model with fallbacks.
     */
    public function getSeoData()
    {
        return $this->seoMeta ?: new SeoMeta();
    }
}
