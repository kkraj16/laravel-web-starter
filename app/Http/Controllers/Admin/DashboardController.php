<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\Testimonial;

use App\Models\Banner;
use App\Models\ProductImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'productsCount' => Product::count(),
            'categoriesCount' => Category::count(),
            'testimonialsCount' => Testimonial::count(),
        ];
        
        return view('admin.dashboard.index', $data);
    }

    public function optimizeImages()
    {
        $messages = [];
        $messages[] = "Starting image optimization...";

        // 1. Banners
        $banners = Banner::where('is_active', true)->get();
        foreach ($banners as $banner) {
            if ($banner->image_path) $this->optimizePath($banner->image_path, $messages);
            if ($banner->mobile_image_path) $this->optimizePath($banner->mobile_image_path, $messages);
            if ($banner->content_image_path) $this->optimizePath($banner->content_image_path, $messages);
        }

        // 2. Trending Products
        $trendingProducts = Product::where('is_active', true)->where('is_trending', true)->get();
        foreach ($trendingProducts as $product) {
            if ($product->thumbnail) $this->optimizePath($product->thumbnail, $messages);
            $images = ProductImage::where('product_id', $product->id)->get();
            foreach ($images as $image) {
                $this->optimizePath($image->image_path, $messages);
            }
        }

        // 3. Static Assets
        $staticAssets = [
            'images/banner/banner-background.jpg',
            'images/banner/logo-text.png',
        ];
        foreach ($staticAssets as $asset) {
            $this->optimizePath($asset, $messages);
        }

        return back()->with('success', 'Home page images optimized successfully! ' . count($messages) . ' operations performed.');
    }

    protected function optimizePath($path, &$messages)
    {
        $fullPath = public_path($path);
        if (!File::exists($fullPath)) {
            $fullPath = Storage::disk('public')->path($path);
        }

        if (!File::exists($fullPath) || is_dir($fullPath)) return;

        $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
        if (!in_array($extension, ['jpg', 'jpeg', 'png'])) return;

        try {
            if ($extension === 'jpg' || $extension === 'jpeg') {
                $image = imagecreatefromjpeg($fullPath);
                if ($image) {
                    imagejpeg($image, $fullPath, 80);
                    imagedestroy($image);
                    $messages[] = "Optimized JPEG: " . basename($path);
                }
            } elseif ($extension === 'png') {
                $image = imagecreatefrompng($fullPath);
                if ($image) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, false);
                    imagesavealpha($image, true);
                    imagepng($image, $fullPath, 9);
                    imagedestroy($image);
                    $messages[] = "Optimized PNG: " . basename($path);
                }
            }
        } catch (\Exception $e) {
            $messages[] = "Error optimizing " . basename($path) . ": " . $e->getMessage();
        }
    }
}
