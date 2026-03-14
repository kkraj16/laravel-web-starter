<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// Frontend
Route::get('/', function () {
    $cacheTtl = 3600; // 1 hour

    $banners = \Illuminate\Support\Facades\Cache::remember('home_banners', $cacheTtl, function () {
        return \App\Models\Banner::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    });

    $products = \Illuminate\Support\Facades\Cache::remember('home_trending_products', $cacheTtl, function () {
        return \App\Models\Product::with('categories')
            ->where('is_active', true)
            ->where('is_trending', true)
            ->latest()
            ->take(8)
            ->get();
    });

    $testimonials = \Illuminate\Support\Facades\Cache::remember('home_testimonials', $cacheTtl, function () {
        return \App\Models\Testimonial::where('is_active', true)
            ->latest()
            ->take(10)
            ->get();
    });
    
    return view('theme::home', compact('products', 'testimonials', 'banners'));
})->name('home');

Route::get('/collections', [\App\Http\Controllers\Frontend\ProductController::class, 'index'])->name('products.index');
Route::get('/product/{slug}', [\App\Http\Controllers\Frontend\ProductController::class, 'show'])->name('products.show');

// Short URL for product sharing (QR codes, WhatsApp, etc.)
Route::get('/p/{id}', function ($id) {
    $product = \App\Models\Product::findOrFail($id);
    return redirect()->route('products.show', $product->slug);
})->name('products.short')->where('id', '[0-9]+');

Route::get('/about', [\App\Http\Controllers\Frontend\PageController::class, 'about'])->name('about');
Route::get('/contact', [\App\Http\Controllers\Frontend\PageController::class, 'contact'])->name('contact');

// Sitemap
Route::get('/sitemap.xml', [\App\Http\Controllers\Frontend\SitemapController::class, 'index'])->name('sitemap');
