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
        $exceptions->render(function (\Throwable $e, \Illuminate\Http\Request $request) {
            if ($e instanceof \Illuminate\Database\QueryException || $e instanceof \PDOException) {
                // Check if it's a connection refused error (2002) or other connection issues
                // Using a broad check for connection issues, usually code 2002
                // We can check $e->getCode() or looking at the message if needed
                // For SQLSTATE[HY000] [2002] Connection refused
                
                if (str_contains($e->getMessage(), 'Connection refused') || $e->getCode() === 2002 || $e->getCode() === 'HY000') {
                     return response()->view('errors.maintenance', [], 503);
                }
            }
        });
    })->create();
