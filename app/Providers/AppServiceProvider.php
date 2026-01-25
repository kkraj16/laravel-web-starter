<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production (Fix for Mixed Content on Render/Heroku)
        if($this->app->environment('production') || $this->app->environment('staging')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Share footer data with footer component
        View::composer('components.frontend.footer', \App\View\Composers\FooterComposer::class);
    }
}
