<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CleanupEmptyRecords extends Command
{
    protected $signature = 'cleanup:empty-records {--dry-run : Show what would be deleted without actually deleting}';
    protected $description = 'Delete empty products, product images, and categories from the database';

    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        
        if ($isDryRun) {
            $this->warn('DRY RUN MODE - No records will be deleted');
        } else {
            if (!$this->confirm('This will permanently delete empty records. Continue?')) {
                $this->info('Operation cancelled');
                return 0;
            }
        }

        $this->info('Starting cleanup process...');
        $this->newLine();

        // 1. Clean up empty products
        $this->cleanupEmptyProducts($isDryRun);
        
        // 2. Clean up orphaned product images
        $this->cleanupOrphanedProductImages($isDryRun);
        
        // 3. Clean up empty categories
        $this->cleanupEmptyCategories($isDryRun);
        
        // 4. Clean up orphaned product_categories relationships
        $this->cleanupOrphanedProductCategories($isDryRun);

        $this->newLine();
        if ($isDryRun) {
            $this->info('✓ Dry run completed. Run without --dry-run to actually delete records.');
        } else {
            $this->info('✓ Cleanup completed successfully!');
        }

        return 0;
    }

    private function cleanupEmptyProducts($isDryRun)
    {
        $this->info('1. Checking for empty products...');
        
        // Products are considered empty if they have no name or no SKU
        $emptyProducts = Product::whereNull('name')
            ->orWhere('name', '')
            ->orWhereNull('sku')
            ->orWhere('sku', '')
            ->get();

        if ($emptyProducts->isEmpty()) {
            $this->line('   No empty products found.');
            return;
        }

        $this->warn("   Found {$emptyProducts->count()} empty product(s)");
        
        foreach ($emptyProducts as $product) {
            $this->line("   - Product ID {$product->id}: " . ($product->name ?: '[No Name]') . " | SKU: " . ($product->sku ?: '[No SKU]'));
        }

        if (!$isDryRun) {
            $count = $emptyProducts->count();
            foreach ($emptyProducts as $product) {
                $product->forceDelete(); // Force delete to bypass soft deletes
            }
            $this->info("   ✓ Deleted {$count} empty product(s)");
        }
    }

    private function cleanupOrphanedProductImages($isDryRun)
    {
        $this->info('2. Checking for orphaned product images...');
        
        // Get product images that don't have a corresponding product
        $orphanedImages = ProductImage::whereNotIn('product_id', Product::pluck('id'))
            ->get();

        if ($orphanedImages->isEmpty()) {
            $this->line('   No orphaned product images found.');
            return;
        }

        $this->warn("   Found {$orphanedImages->count()} orphaned product image(s)");
        
        foreach ($orphanedImages  as $image) {
            $this->line("   - Image ID {$image->id} (Product ID: {$image->product_id})");
        }

        if (!$isDryRun) {
            $count = $orphanedImages->count();
            ProductImage::whereNotIn('product_id', Product::pluck('id'))->delete();
            $this->info("   ✓ Deleted {$count} orphaned product image(s)");
        }
    }

    private function cleanupEmptyCategories($isDryRun)
    {
        $this->info('3. Checking for empty categories...');
        
        // Categories are considered empty if they have no name
        $emptyCategories = Category::whereNull('name')
            ->orWhere('name', '')
            ->get();

        if ($emptyCategories->isEmpty()) {
            $this->line('   No empty categories found.');
            return;
        }

        $this->warn("   Found {$emptyCategories->count()} empty categor(ies)");
        
        foreach ($emptyCategories as $category) {
            $this->line("   - Category ID {$category->id}: " . ($category->name ?: '[No Name]'));
        }

        if (!$isDryRun) {
            $count = $emptyCategories->count();
            foreach ($emptyCategories as $category) {
                $category->forceDelete(); // Force delete to bypass soft deletes
            }
            $this->info("   ✓ Deleted {$count} empty categor(ies)");
        }
    }

    private function cleanupOrphanedProductCategories($isDryRun)
    {
        $this->info('4. Checking for orphaned product-category relationships...');
        
        $productIds = Product::pluck('id')->toArray();
        $categoryIds = Category::pluck('id')->toArray();
        
        // Count orphaned relationships
        $orphanedCount = DB::table('product_categories')
            ->where(function($query) use ($productIds) {
                $query->whereNotIn('product_id', $productIds);
            })
            ->orWhere(function($query) use ($categoryIds) {
                $query->whereNotIn('category_id', $categoryIds);
            })
            ->count();

        if ($orphanedCount === 0) {
            $this->line('   No orphaned product-category relationships found.');
            return;
        }

        $this->warn("   Found {$orphanedCount} orphaned relationship(s) in product_categories table");

        if (!$isDryRun) {
            DB::table('product_categories')
                ->where(function($query) use ($productIds) {
                    $query->whereNotIn('product_id', $productIds);
                })
                ->orWhere(function($query) use ($categoryIds) {
                    $query->whereNotIn('category_id', $categoryIds);
                })
                ->delete();
            
            $this->info("   ✓ Deleted {$orphanedCount} orphaned relationship(s)");
        }
    }
}
