<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\SeoComposer;

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
        // Force URL scheme to match APP_URL (works for both HTTP and HTTPS)
        $scheme = parse_url(config('app.url'), PHP_URL_SCHEME);
        if ($scheme) {
            \Illuminate\Support\Facades\URL::forceScheme($scheme);
        }

        // Share footer data with footer component
        View::composer('components.frontend.footer', \App\View\Composers\FooterComposer::class);

        // Bind SEO data to the main layout
        View::composer('themes.default.layout', SeoComposer::class);
        View::composer('themes.default.layouts.app', SeoComposer::class);
    }
}
