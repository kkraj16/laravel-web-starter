<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes;
    
    protected static function booted()
    {
        static::saved(fn () => \Illuminate\Support\Facades\Cache::forget('home_testimonials'));
        static::deleted(fn () => \Illuminate\Support\Facades\Cache::forget('home_testimonials'));
    }

    protected $fillable = [
        'name',
        'content',
        'rating',
        'is_active',
        'review_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'review_date' => 'date',
    ];
}
