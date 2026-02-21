<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class CheckInstalled
{
    public function handle(Request $request, Closure $next): Response
    {
        $isInstallerRoute = $request->is('install') || $request->is('install/*');
        $isInstalled = File::exists(storage_path('installed'));

        // Not installed → redirect to installer (but allow installer routes)
        if (!$isInstalled) {
            // Auto-generate APP_KEY if missing (required for CSRF/sessions)
            if (empty(config('app.key'))) {
                $this->ensureAppKey();
            }

            if (!$isInstallerRoute) {
                return redirect()->route('installer.welcome');
            }
            return $next($request);
        }

        // Installed but tables might be missing (DB was wiped)
        if (!$isInstallerRoute) {
            try {
                if (!\Illuminate\Support\Facades\Schema::hasTable('users')) {
                    File::delete(storage_path('installed'));
                    return redirect()->route('installer.welcome');
                }
            } catch (\Exception $e) {
                // DB is completely unreachable
                if (!config('app.debug')) {
                    return response()->view('errors.maintenance', [], 503);
                }
                throw $e;
            }
        }

        // Already installed → block installer routes
        if ($isInstallerRoute) {
            return redirect('/');
        }

        return $next($request);
    }

    /**
     * Generate .env file and APP_KEY if missing.
     * Required for the installer to function (CSRF tokens, sessions).
     */
    private function ensureAppKey(): void
    {
        try {
            // Create .env from .env.example if it doesn't exist
            $envPath = base_path('.env');
            if (!File::exists($envPath)) {
                $examplePath = base_path('.env.example');
                if (File::exists($examplePath)) {
                    File::copy($examplePath, $envPath);
                } else {
                    // No .env.example either — create a bare minimum .env
                    File::put($envPath, "APP_NAME=\"Ratannam Gold\"\nAPP_ENV=production\nAPP_KEY=\nAPP_DEBUG=false\nAPP_URL=http://localhost\n");
                }
            }

            Artisan::call('key:generate', ['--force' => true]);

            // Reload the config so the new key is available immediately
            $envKey = $this->readKeyFromEnv();
            if ($envKey) {
                config(['app.key' => $envKey]);
            }
        } catch (\Exception $e) {
            // If key generation fails, the installer can still show
            // but CSRF/sessions won't work. Let it fail visibly in debug.
        }
    }

    /**
     * Read the APP_KEY directly from .env file
     */
    private function readKeyFromEnv(): ?string
    {
        $envPath = base_path('.env');
        if (!File::exists($envPath)) {
            return null;
        }

        $content = File::get($envPath);
        if (preg_match('/^APP_KEY=(.+)$/m', $content, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }
}
