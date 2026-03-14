<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    
    protected static function booted()
    {
        static::saved(fn () => \Illuminate\Support\Facades\Cache::forget('home_banners'));
        static::deleted(fn () => \Illuminate\Support\Facades\Cache::forget('home_banners'));
    }

    protected $fillable = [
        'title',
        'subtitle',
        'text_alignment',
        'image_path',
        'mobile_image_path',
        'button_text',
        'button_link',
        'sort_order',
        'is_active',
        'show_content',
        'overlay_opacity',
        'animate_image',
        'content_image_path',
        'show_content_image',
        'content_position',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_content' => 'boolean',
        'animate_image' => 'boolean',
        'show_content_image' => 'boolean',
        'sort_order' => 'integer',
        'overlay_opacity' => 'float',
    ];

    public function getDisplayOpacityAttribute()
    {
        // Heuristic: If opacity is the old default (0.6), treat it as 0.2
        return ($this->overlay_opacity == 0.6) ? 0.2 : $this->overlay_opacity;
    }
}
