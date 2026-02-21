<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
    web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/installer.php'));
            
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\CheckInstalled::class,
        ]);
        
        // Trust Render/AWS Proxies for HTTPS detection
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle missing APP_KEY (fresh install)
        $exceptions->render(function (\Illuminate\Encryption\MissingAppKeyException $e, \Illuminate\Http\Request $request) {
            // If not installed yet, redirect to installer
            if (!\Illuminate\Support\Facades\File::exists(storage_path('installed'))) {
                // Try to generate a key so the installer can work
                try {
                    \Illuminate\Support\Facades\Artisan::call('key:generate', ['--force' => true]);
                    return redirect($request->url());
                } catch (\Exception $ex) {
                    // fallthrough
                }
            }
            return response()->view('errors.maintenance', [], 503);
        });

        // Handle ALL database errors gracefully in production
        $exceptions->render(function (\Throwable $e, \Illuminate\Http\Request $request) {

            // Only intercept in production (let debug mode show full errors for devs)
            if (config('app.debug')) {
                return null; // Let Laravel's default handler show the debug page
            }

            $isDbError = $e instanceof \Illuminate\Database\QueryException
                      || $e instanceof \PDOException;

            if (!$isDbError) {
                return null;
            }

            $message = $e->getMessage();
            $code    = $e->getCode();

            // Connection refused (MySQL not running)
            // Unknown database (DB doesn't exist)
            // Access denied (wrong credentials)
            // Table not found (migrations not run)
            // General SQLSTATE errors
            $isHandled = str_contains($message, 'Connection refused')       // MySQL down
                      || str_contains($message, 'Unknown database')         // DB missing
                      || str_contains($message, 'Access denied')            // Wrong creds
                      || str_contains($message, 'doesn\'t exist')           // Table missing
                      || str_contains($message, 'Base table or view not found') // Table missing
                      || $code === 2002                                     // Connection refused code
                      || $code === 1049                                     // Unknown database code
                      || $code === 1045                                     // Access denied code
                      || $code === '42S02'                                  // Table not found SQLSTATE
                      || $code === 'HY000';                                 // General SQLSTATE

            if ($isHandled) {
                return response()->view('errors.maintenance', [], 503);
            }

            return null;
        });
    })->create();
