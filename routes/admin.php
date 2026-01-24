<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [\App\Http\Controllers\Admin\UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\Admin\UserController::class, 'updateProfile'])->name('profile.update');
    
    // RBAC Routes
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    Route::post('permissions/matrix', [\App\Http\Controllers\Admin\PermissionController::class, 'updateMatrix'])->name('permissions.updateMatrix');
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
    
    // Shop Routes
    Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class);
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
    
    // Product Routes
    Route::resource('products', ProductController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
    Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);
    Route::post('banners/{banner}/toggle-active', [\App\Http\Controllers\Admin\BannerController::class, 'toggleActive'])->name('banners.toggle-active');

    // Settings Routes
    // Settings Routes
    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::get('/', function() { return redirect()->route('admin.settings.contact'); })->name('index'); // Redirect generic to contact
        
        Route::get('contact', [\App\Http\Controllers\Admin\SettingController::class, 'contact'])->name('contact');
        Route::get('seo', [\App\Http\Controllers\Admin\SettingController::class, 'seo'])->name('seo');
        Route::get('markets', [\App\Http\Controllers\Admin\SettingController::class, 'markets'])->name('markets');
        Route::get('global', [\App\Http\Controllers\Admin\SettingController::class, 'globalConfig'])->name('global');

        // Update Routes
        Route::post('update', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('update'); // Generic updater
        Route::post('rates', [\App\Http\Controllers\Admin\SettingController::class, 'updateRates'])->name('update-rates'); // Specific for rates if needed or reuse generic
    });
});
