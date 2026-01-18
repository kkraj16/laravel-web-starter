<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class ProductSqlSeeder extends Seeder
{
    public function run()
    {
        // 1. Define Luxury Images by Category/Type
        $luxuryImages = [
            'Bridal' => [
                'https://images.unsplash.com/photo-1599643478518-17488fbbcd75?q=80&w=2574&auto=format&fit=crop', // Necklace
                'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?q=80&w=2670&auto=format&fit=crop', // Gold Set
                'https://images.unsplash.com/photo-1601121141461-9d6647bca1ed?q=80&w=2623&auto=format&fit=crop', // Indian Bridal
                'https://images.unsplash.com/photo-1543294001-f7cd5d7fb516?q=80&w=2670&auto=format&fit=crop', // Traditional
            ],
            'Men & Kids' => [
                'https://images.unsplash.com/photo-1620783770629-122b78e836b9?q=80&w=2670&auto=format&fit=crop', // Watch/Bracelet
                'https://images.unsplash.com/photo-1617038224558-28809c88429c?q=80&w=2670&auto=format&fit=crop', // Ring
                'https://images.unsplash.com/photo-1618331835717-801e976710b2?q=80&w=2535&auto=format&fit=crop', // Cufflinks
            ],
            'Coins & Gifts' => [
                'https://images.unsplash.com/photo-1610375461246-83df859d849d?q=80&w=2670&auto=format&fit=crop', // Gold Coins
                'https://images.unsplash.com/photo-1563298723-dcfebaa392e3?q=80&w=2667&auto=format&fit=crop', // Gift Box
            ],
            'Silver' => [
                'https://images.unsplash.com/photo-1611591437281-460bfbe1220a?q=80&w=2670&auto=format&fit=crop', // Silver jewellery
                'https://images.unsplash.com/photo-1576723444548-e264b735aa41?q=80&w=2574&auto=format&fit=crop', // Silver ring
            ],
            'Gold' => [
                 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=2670&auto=format&fit=crop', // Gold Ring
                 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=2574&auto=format&fit=crop', // Gold Earring
                 'https://images.unsplash.com/photo-1589128040287-dc5f532a1885?q=80&w=2572&auto=format&fit=crop', // Bangles
            ],
            'Daily Wear' => [
                'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?q=80&w=2670&auto=format&fit=crop', // Light chain
                'https://images.unsplash.com/photo-1611085583191-a3b181a88401?q=80&w=2670&auto=format&fit=crop', // Simple ring
            ],
            'Default' => [
                'https://images.unsplash.com/photo-1579407364450-481fe19dbfaa?q=80&w=2576&auto=format&fit=crop',
            ]
        ];

        // 2. Read the SQL File
        $sqlPath = base_path('Product_rows.sql');
        if (!file_exists($sqlPath)) {
            $this->command->error("SQL file not found at: $sqlPath");
             return;
        }

        $content = file_get_contents($sqlPath);
        
        // 3. Regex to extract values
        // Matches: ('id', 'name', 'slug', 'description', 'price', 'discount', 'material', 'purity', 'weight', 'isTrending', 'isTreasuryHighlight', 'showOnHomepage', 'categoryId', ...)
        // Note: The SQL values are single quoted. We need to be careful with regex.
        // Simplified approach: Parse chunks between parantheses after VALUES
        
        // Let's strip the INSERT INTO part and just get the giant value list.
        $values = Str::after($content, 'VALUES ');
        
        // This is a bit tricky with regex because of potential commas in descriptions.
        // Assuming standard SQL dump format where strings are 'escaped'. 
        // We will perform a basic split but we must respect quoted strings.
        
        // Better: Let's assume standard format and match patterns.
        // Format: ('id', 'name', 'slug', 'desc', 'price', 'disc', 'mat', 'pur', 'wgt', 'trend', 'treas', 'home', 'cat', 'cr', 'up', 'pub', 'stk')
        // Count: 17 columns
        
        // Let's clear existing products for a clean seed? Or append? Let's clear to avoid duplicate keys.
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        ProductImage::truncate();
        // Don't truncate categories, we might want to keep if existing.
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Manual parsing loop
        $rows = explode("), (", $values);
        
        foreach ($rows as $index => $row) {
             // clean up start/end chars
             $row = trim($row, "(); \n\r");
             
             // Split by comma, but ignore commas inside quotes
             $columns = str_getcsv($row, ",", "'"); // Warning: str_getcsv uses " as default enclosure, we sett explicitly
             
             // Mapping based on SQL structure:
             // 0:id, 1:name, 2:slug, 3:description, 4:price, 5:discount, 6:material, 7:purity, 8:weight
             // 9:isTrending, 10:isTreasury, 11:showOnHome, 12:categoryId
             
             if (count($columns) < 13) continue; // Skip malformed
             
             $name = $columns[1];
             $slug = $columns[2];
             $description = $columns[3];
             $price = floatval($columns[4]);
             $material = $columns[6];
             $purity = $columns[7];
             $weight = floatval($columns[8]);
             $isTrending = $columns[9] === 'true';
             $showOnHomepage = $columns[11] === 'true'; // Index 11 is showOnHompage
             
             // 4. Determine Category from Description
             // "from our Men & Kids collection"
             // "from our Bridal Jewellery collection"
             $categoryName = 'General';
             $imageType = 'Default';
             
             if (Str::contains($description, 'Men & Kids')) {
                 $categoryName = 'Men & Kids';
                 $imageType = 'Men & Kids';
             } elseif (Str::contains($description, 'Bridal Jewellery')) {
                 $categoryName = 'Bridal Jewellery';
                 $imageType = 'Bridal';
             } elseif (Str::contains($description, 'Coins & Gifts')) {
                 $categoryName = 'Coins & Gifts';
                 $imageType = 'Coins & Gifts';
             } elseif (Str::contains($description, 'Daily Wear')) {
                 $categoryName = 'Daily Wear';
                 $imageType = 'Daily Wear';
             } elseif (Str::contains($description, 'Silver Jewellery')) {
                 $categoryName = 'Silver Jewellery';
                 $imageType = 'Silver';
             } elseif (Str::contains($description, 'Gold Jewellery')) {
                 $categoryName = 'Gold Jewellery';
                 $imageType = 'Gold';
             }
             
             // Create or Find Category by Slug to avoid unique errors
             $catSlug = Str::slug($categoryName);
             $category = Category::withTrashed()->where('slug', $catSlug)->first();
             
             if (!$category) {
                 $category = Category::create(['name' => $categoryName, 'slug' => $catSlug]);
             } elseif ($category->trashed()) {
                 $category->restore();
             }
             
             // 5. Create Product
             $product = Product::create([
                 'name' => $name,
                 'slug' => $slug . '-' . Str::random(4), // Ensure unique slug even if duplicates in SQL
                 'description' => $description,
                 'price' => $price,
                 'material' => $material,
                 'purity' => $purity,
                 'weight' => $weight,
                 'is_trending' => $isTrending,
                 // 'category_id' => $category->id, // Removed as column was dropped
                 'is_active' => true,
                 'sku' => strtoupper(Str::random(8)),
             ]);
             
             // Attach Category
             $product->categories()->attach($category->id);
             
             // 6. Assign Image
             // Pick random image from type
             $images = $luxuryImages[$imageType] ?? $luxuryImages['Default'];
             $imageUrl = $images[array_rand($images)];
             
             ProductImage::create([
                 'product_id' => $product->id,
                 'image_path' => $imageUrl, // Storing full URL for demo, usually this is path
                 'is_primary' => true
             ]);
        }
        
        $this->command->info('Products seeded successfully matching categories and luxury images.');
    }
}
