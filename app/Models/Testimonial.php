<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes;

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
