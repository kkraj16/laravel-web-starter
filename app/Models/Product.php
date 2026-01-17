<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 
        'slug',
        'short_description', 
        'description',
        'product_type', // simple, variable, digital
        'brand_id',
        'price', 
        'sale_price', 
        'sale_start',
        'sale_end',
        'tax_class',
        'sku', 
        'stock_quantity', 
        'manage_stock',
        'stock_status', // instock, outofstock, onbackorder
        'is_active',
        'thumbnail',
        'gallery',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    protected $casts = [
        'manage_stock' => 'boolean',
        'is_active' => 'boolean',
        'gallery' => 'array',
        'sale_start' => 'datetime',
        'sale_end' => 'datetime',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class); // Keeping for backward compatibility or main gallery management
    }
    
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function getPrimaryImageAttribute()
    {
        // Return thumbnail if set, else first image from relation
        return $this->thumbnail ? asset('storage/'.$this->thumbnail) : 
                ($this->images->where('is_primary', true)->first() ? asset('storage/'.$this->images->where('is_primary', true)->first()->image_path) : asset('images/placeholder.png'));
    }
}
