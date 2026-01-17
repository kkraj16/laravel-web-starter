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
        DB::table('products')->insert([
            'category_id' => $catId,
            'name' => 'Classic Gold Band',
            'slug' => 'classic-gold-band',
            'description' => 'A timeless classic gold band.',
            'price' => 25000.00,
            'stock_quantity' => 10,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Banners
        DB::table('banners')->insert([
            'title' => 'New Collection',
            'image_path' => '/images/banner1.jpg',
            'position' => 'home_slider',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
