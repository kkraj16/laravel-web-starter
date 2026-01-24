<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ResetProductData extends Command
{
    protected $signature = 'products:reset {--force : Skip confirmation prompt}';
    protected $description = 'Delete ALL product data (products, images, relationships) for fresh start';

    public function handle()
    {
        $this->error('⚠️  WARNING: This will delete ALL product data!');
        $this->newLine();
        
        // Count current records
        $productCount = Product::count();
        $imageCount = ProductImage::count();
        $relationshipCount = DB::table('product_categories')->count();
        $variantCount = ProductVariant::count();
        
        $this->warn("Current database state:");
        $this->line("  - Products: {$productCount}");
        $this->line("  - Product Images: {$imageCount}");
        $this->line("  - Product-Category Relationships: {$relationshipCount}");
        $this->line("  - Product Variants: {$variantCount}");
        $this->newLine();

        if ($productCount === 0) {
            $this->info('No products found. Database is already empty.');
            return 0;
        }

        if (!$this->option('force')) {
            $this->error('This action CANNOT be undone!');
            if (!$this->confirm('Are you absolutely sure you want to delete ALL product data?')) {
                $this->info('Operation cancelled.');
                return 0;
            }

            // Double confirmation
            if (!$this->confirm('This is your last chance. Delete everything?', false)) {
                $this->info('Operation cancelled.');
                return 0;
            }
        }

        $this->info('Starting deletion process...');
        $this->newLine();

        // 1. Delete product-category relationships
        $this->line('→ Deleting product-category relationships...');
        DB::table('product_categories')->delete();
        $this->info("  ✓ Deleted {$relationshipCount} relationship(s)");

        // 2. Delete product variants
        $this->line('→ Deleting product variants...');
        ProductVariant::query()->delete();
        $this->info("  ✓ Deleted {$variantCount} variant(s)");

        // 3. Delete product images (records)
        $this->line('→ Deleting product image records...');
        ProductImage::query()->delete();
        $this->info("  ✓ Deleted {$imageCount} image record(s)");

        // 4. Delete products (force delete to bypass soft deletes)
        $this->line('→ Deleting all products...');
        Product::query()->forceDelete();
        $this->info("  ✓ Deleted {$productCount} product(s)");

        // 5. Clean up storage files
        $this->line('→ Cleaning up product image files from storage...');
        $deletedFiles = 0;
        if (Storage::disk('public')->exists('products')) {
            $files = Storage::disk('public')->allFiles('products');
            foreach ($files as $file) {
                Storage::disk('public')->delete($file);
                $deletedFiles++;
            }
        }
        $this->info("  ✓ Deleted {$deletedFiles} file(s) from storage");

        $this->newLine();
        $this->info('✓ Product data reset completed successfully!');
        $this->line('  - All products deleted');
        $this->line('  - All product images deleted');
        $this->line('  - All relationships cleared');
        $this->line('  - Storage files deleted');
        $this->newLine();
        $this->info('You can now add fresh product data.');

        return 0;
    }
}
