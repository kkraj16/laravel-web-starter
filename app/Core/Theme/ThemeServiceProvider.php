<?php

namespace App\Core\Theme;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class ThemeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        try {
            if (Schema::hasTable('settings')) {
                // Fetch active theme from settings, default to 'default'
                $activeTheme = DB::table('settings')
                                ->where('key', 'active_theme')
                                ->value('value') ?? 'default';

                // Add theme view path
                // Usage: view('theme::page') or just standard overrides if we prepend
                
                // Strategy: Add the theme directory as a namespace 'theme'
                $themePath = resource_path("views/themes/{$activeTheme}");
                
                if (is_dir($themePath)) {
                    View::addNamespace('theme', $themePath);
                } else {
                    // Fallback to default if selected theme missing
                    View::addNamespace('theme', resource_path("views/themes/default"));
                }
            }
        } catch (\Exception $e) {
            // Failsafe during migration/install
        }
    }
}
