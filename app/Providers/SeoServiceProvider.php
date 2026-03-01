<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SeoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('theme::layout', \App\Http\View\Composers\SeoComposer::class);
        // Also register for the default layout if theme namespace is not used correctly everywhere
        view()->composer('themes.default.layout', \App\Http\View\Composers\SeoComposer::class);
    }
}
