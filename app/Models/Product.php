<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

use App\Traits\HasSeo;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasSeo;

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

    public function getPriceAttribute($value)
    {
        // Sanitize string values with commas (e.g. "76,500") to float
        if (is_string($value)) {
            return (float) str_replace(',', '', $value);
        }
        return (float) $value;
    }

    public function getSalePriceAttribute($value)
    {
        if (is_string($value)) {
            return (float) str_replace(',', '', $value);
        }
        return $value ? (float) $value : null;
    }

    /**
     * Set a specific image as the primary image for the product.
     * 
     * @param int|null $imageId ID of the ProductImage to set as primary
     * @param string|null $imagePath Path to set as thumbnail if imageId is not provided
     * @return void
     */
    public function setPrimaryImage($imageId = null, $imagePath = null)
    {
        if ($imageId) {
            $image = $this->images()->find($imageId);
            if ($image) {
                $this->images()->where('id', '!=', $imageId)->update(['is_primary' => false]);
                $image->update(['is_primary' => true]);
                $this->update(['thumbnail' => $image->image_path]);
            }
        } elseif ($imagePath) {
            $this->images()->update(['is_primary' => false]);
            $this->images()->where('image_path', $imagePath)->update(['is_primary' => true]);
            $this->update(['thumbnail' => $imagePath]);
        }
    }
}
