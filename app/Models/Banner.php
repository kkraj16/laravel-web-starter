<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'text_alignment',
        'image_path',
        'mobile_image_path',
        'button_text',
        'button_link',
        'order',
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
    ];
}
