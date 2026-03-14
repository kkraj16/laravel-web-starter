<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;

class ImportProductsFromImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:import-from-images {directory : The path to the directory containing images (e.g. public/uploads/temp)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products by scanning images, generating details via AI, and adding them to the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = $this->argument('directory');
        $host = env('OLLAMA_HOST', 'http://localhost:11434');
        $model = env('OLLAMA_MODEL', 'llava:latest');

        // Handle path depending on where user executes it
        $path = base_path($directory);
        if (!File::exists($path)) {
            $path = public_path($directory);
        }
        
        if (!File::exists($path) && !File::isDirectory($path)) {
            $this->error("Directory not found: {$directory} (checked in base_path and public_path)");
            return 1;
        }

        $files = File::files($path);
        
        $images = array_filter($files, function ($file) {
            return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp']);
        });

        if (empty($images)) {
            $this->info("No images found in {$directory}");
            return 0;
        }

        $this->info("Found " . count($images) . " images in {$path}. Starting auto-generation via Ollama ({$model})...");

        // Prepare migration directories
        $migrationRoot = public_path('uploads/migration_ready');
        $migrationImageDir = $migrationRoot . '/images/products';
        $sqlFilePath = $migrationRoot . '/products.sql';

        if (!File::exists($migrationImageDir)) {
            File::makeDirectory($migrationImageDir, 0755, true);
        }
        
        // Clear or create SQL file
        File::put($sqlFilePath, "-- Product Migration SQL Generated on " . date('Y-m-d H:i:s') . "\n\n");

        foreach ($images as $image) {
            $this->info("\nProcessing: " . $image->getFilename());
            
            $base64 = base64_encode(File::get($image->getRealPath()));
            
            $this->line("Calling Ollama Vision API...");
            
            // Call local Ollama API
            $response = Http::timeout(240)->post("{$host}/api/generate", [
                'model' => $model,
                'prompt' => "Analyze this jewelry image and provide a JSON response with exactly five keys: 'title' (a catchy product title), 'short_description' (1 to 2 sentences), 'description' (a detailed, engaging product description suitable for a luxury jewelry e-commerce site focusing on the materials, design, and elegance), 'sku' (a unique professional-sounding SKU like RG-RNG-001 based on the item type), and 'categories' (an array of exactly matching strings selecting 1 or more suitable categories from this list: ['Coins & Gifts', 'Gold Jewellery', 'Silver Jewellery', 'Bridal Jewellery', 'Daily Wear Jewellery', 'Men & Kids']). Look closely at the image to identify diamond and gold variations appropriately. Return ONLY the raw JSON string, no explanation, no markdown formatting.",
                'stream' => false,
                'images' => [$base64],
                'format' => 'json'
            ]);

            if ($response->failed()) {
                $this->error("API Request failed for " . $image->getFilename() . ": " . $response->body());
                continue;
            }

            try {
                $result = $response->json();
                $textRaw = $result['response'] ?? '';
                
                // Strip markdown json block just in case
                $textRaw = str_replace(['```json', '```'], '', $textRaw);
                $data = json_decode(trim($textRaw), true);

                if (!$data || !isset($data['title'])) {
                    $this->error("Invalid JSON response from AI for " . $image->getFilename());
                    $this->line("Raw response: " . $textRaw);
                    continue;
                }

                // Match production naming: products/randomname.ext
                $targetDir = 'products';
                if (!Storage::disk('public')->exists($targetDir)) {
                    Storage::disk('public')->makeDirectory($targetDir);
                }
                
                $newName = Str::random(40) . '.' . $image->getExtension();
                $targetPath = $targetDir . '/' . $newName;
                
                Storage::disk('public')->put($targetPath, File::get($image->getRealPath()));
                
                // Also copy to migration folder (keep same relative path)
                if (!File::exists($migrationImageDir)) {
                    File::makeDirectory($migrationImageDir, 0755, true);
                }
                File::copy($image->getRealPath(), $migrationImageDir . '/' . $newName);

                // Ensure a unique slug
                $slug = Str::slug($data['title']);
                $originalSlug = $slug;
                $counter = 1;
                while (Product::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }

                // Ensure a unique SKU
                $sku = $data['sku'] ?? ('RG-' . strtoupper(Str::random(6)));
                $originalSku = $sku;
                $counter = 1;
                while (Product::where('sku', $sku)->exists()) {
                    $sku = $originalSku . '-' . $counter;
                    $counter++;
                }

                $shortDesc = addslashes($data['short_description'] ?? '');
                $desc = addslashes($data['description'] ?? '');
                $name = addslashes($data['title']);

                $product = Product::create([
                    'name' => $data['title'],
                    'slug' => $slug,
                    'short_description' => $data['short_description'] ?? null,
                    'description' => $data['description'] ?? null,
                    'sku' => $sku,
                    'thumbnail' => $targetPath,
                    'is_active' => false,
                    'product_type' => 'simple',
                    'stock_status' => 'instock',
                    'manage_stock' => true,
                    'stock_quantity' => 1,
                    'price' => 0, 
                ]);

                // Create ProductImage record
                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $targetPath,
                    'is_primary' => true
                ]);

                // Generate SQL for this product
                $sql = "INSERT INTO products (name, slug, short_description, description, sku, thumbnail, is_active, product_type, stock_status, manage_stock, stock_quantity, price, created_at, updated_at) VALUES ('{$name}', '{$slug}', '{$shortDesc}', '{$desc}', '{$sku}', '{$targetPath}', 0, 'simple', 'instock', 1, 1, 0, NOW(), NOW());\n";
                $sql .= "SET @last_id = LAST_INSERT_ID();\n";
                $sql .= "INSERT INTO product_images (product_id, image_path, is_primary) VALUES (@last_id, '{$targetPath}', 1);\n";

                // Attach categories
                if (!empty($data['categories']) && is_array($data['categories'])) {
                    $categoryIds = Category::whereIn('name', $data['categories'])->pluck('id');
                    if ($categoryIds->isNotEmpty()) {
                        $product->categories()->attach($categoryIds);
                        
                        foreach($categoryIds as $catId) {
                            $sql .= "INSERT INTO product_categories (product_id, category_id) VALUES (@last_id, {$catId});\n";
                        }
                    }
                }
                
                File::append($sqlFilePath, $sql . "\n");

                if(method_exists($product, 'generateSeoDefaults')) {
                    $product->generateSeoDefaults();
                }

                $this->info("✅ Created product: " . $product->name . " (ID: " . $product->id . ")");

            } catch (\Exception $e) {
                $this->error("Error processing " . $image->getFilename() . ": " . $e->getMessage());
            }
        }

        $this->info("\nImport complete!");
        $this->info("SQL script ready at: " . $sqlFilePath);
        $this->info("Images ready to upload at: " . $migrationImageDir);
        return 0;
    }
}
