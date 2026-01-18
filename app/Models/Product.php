<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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
        'meta_keywords',
        'material',
        'purity',
        'weight',
        'is_trending'
    ];

    protected $casts = [
        'manage_stock' => 'boolean',
        'is_active' => 'boolean',
        'gallery' => 'array',
        'sale_start' => 'datetime',
        'sale_end' => 'datetime',
        'is_trending' => 'boolean',
        'material' => \App\Enums\ProductMaterial::class,
        'purity' => \App\Enums\ProductPurity::class,
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
        $path = $this->thumbnail;
        
        if(!$path) {
            $primary = $this->images->where('is_primary', true)->first();
            $path = $primary ? $primary->image_path : null;
        }

        if(!$path) return asset('images/placeholder.png');

        return Str::startsWith($path, 'http') ? $path : asset('storage/' . $path);
    }
}
