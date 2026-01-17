<?php

use App\Core\Installer\InstallerController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'install', 'as' => 'installer.', 'middleware' => ['web']], function () {
    Route::get('/', [InstallerController::class, 'welcome'])->name('welcome');
    Route::get('/requirements', [InstallerController::class, 'requirements'])->name('requirements');
    Route::get('/environment', [InstallerController::class, 'environment'])->name('environment');
    Route::post('/environment', [InstallerController::class, 'saveEnvironment'])->name('environment.save');
    Route::get('/migrations', [InstallerController::class, 'runMigrations'])->name('migrations');
    Route::get('/finish', [InstallerController::class, 'finish'])->name('finish');
});
