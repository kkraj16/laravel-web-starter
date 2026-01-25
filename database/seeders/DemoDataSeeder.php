<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        $catId = DB::table('categories')->insertGetId([
            'name' => 'Gold Rings',
            'slug' => 'gold-rings',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Products
        $productId = DB::table('products')->insertGetId([
            // 'category_id' => $catId, // Removed
            'name' => 'Classic Gold Band',
            'slug' => 'classic-gold-band',
            'description' => 'A timeless classic gold band.',
            'price' => 25000.00,
            'stock_quantity' => 10,
            'manage_stock' => true,
            'stock_status' => 'instock',
            'product_type' => 'simple',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Pivot: Assign Category
        DB::table('product_categories')->insert([
            'product_id' => $productId,
            'category_id' => $catId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Banners
        DB::table('banners')->insert([
            'title' => 'New Collection',
            'image_path' => '/images/banner1.jpg',
            // 'position' => 'home_slider', // Removed as column doesn't exist
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
