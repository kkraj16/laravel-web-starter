<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Banner;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class OptimizeHomeImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:optimize-home {--force : Re-optimize even if webp exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate WebP versions and optimize home page images (banners and trending products)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Starting home page image optimization...");

        // 1. Banners
        $this->info("Optimizing Banners...");
        $banners = Banner::where('is_active', true)->get();
        foreach ($banners as $banner) {
            if ($banner->image_path) {
                $this->optimizeImagePath($banner->image_path);
            }
            if ($banner->mobile_image_path) {
                $this->optimizeImagePath($banner->mobile_image_path);
            }
            if ($banner->content_image_path) {
                $this->optimizeImagePath($banner->content_image_path);
            }
        }

        // 2. Trending Products
        $this->info("Optimizing Trending Products...");
        $trendingProducts = Product::where('is_active', true)->where('is_trending', true)->get();
        foreach ($trendingProducts as $product) {
            // Main thumbnail
            if ($product->thumbnail) {
                $this->optimizeImagePath($product->thumbnail);
            }

            // All product images
            $images = ProductImage::where('product_id', $product->id)->get();
            foreach ($images as $image) {
                $this->optimizeImagePath($image->image_path);
            }
        }

        // 3. Static Assets
        $this->info("Optimizing Static Assets...");
        $staticAssets = [
            'images/banner/banner-background.jpg',
            'images/banner/logo-text.png',
        ];
        foreach ($staticAssets as $asset) {
            $this->optimizeImagePath($asset);
        }

        $this->info("Optimization complete!");
        return 0;
    }

    /**
     * Create WebP version of an image
     *
     * @param string $path Relative path in storage/app/public or public/uploads
     */
    protected function optimizeImagePath($path)
    {
        // Try to find the file
        $fullPath = public_path($path);
        if (!File::exists($fullPath)) {
            // Check in storage
            $fullPath = Storage::disk('public')->path($path);
        }

        if (!File::exists($fullPath) || is_dir($fullPath)) {
            $this->warn("File not found: {$path}");
            return;
        }

        $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
        if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
            return;
        }

        $this->line("Optimizing: " . basename($path));

        try {
            $image = null;
            if ($extension === 'jpg' || $extension === 'jpeg') {
                $image = imagecreatefromjpeg($fullPath);
                if ($image) {
                    imagejpeg($image, $fullPath, 80); // Overwrite with 80% quality
                    imagedestroy($image);
                    $this->info("  Compressed JPEG: " . basename($path));
                }
            } elseif ($extension === 'png') {
                $image = imagecreatefrompng($fullPath);
                if ($image) {
                    imagepalettetotruecolor($image); 
                    imagealphablending($image, false);
                    imagesavealpha($image, true);
                    imagepng($image, $fullPath, 9); // Max compression for PNG
                    imagedestroy($image);
                    $this->info("  Compressed PNG: " . basename($path));
                }
            }
        } catch (\Exception $e) {
            $this->error("  Failed to optimize " . basename($path) . ": " . $e->getMessage());
        }
    }
}
