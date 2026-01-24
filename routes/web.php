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
    $products = \App\Models\Product::with('categories')
                ->where('is_active', true)
                ->where('is_trending', true)
                ->latest()
                ->take(8)
                ->get();

    $banners = \App\Models\Banner::where('is_active', true)
                ->orderBy('sort_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();

    $testimonials = \App\Models\Testimonial::where('is_active', true)
                    ->latest()
                    ->take(10)
                    ->get();
    
    return view('theme::home', compact('products', 'testimonials', 'banners'));
})->name('home');

Route::get('/collections', [\App\Http\Controllers\Frontend\ProductController::class, 'index'])->name('products.index');
Route::get('/product/{slug}', [\App\Http\Controllers\Frontend\ProductController::class, 'show'])->name('products.show');

Route::get('/about', [\App\Http\Controllers\Frontend\PageController::class, 'about'])->name('about');
Route::get('/contact', [\App\Http\Controllers\Frontend\PageController::class, 'contact'])->name('contact');
