<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class CheckInstalled
{
    public function handle(Request $request, Closure $next): Response
    {
        $isInstalled = File::exists(storage_path('installed'));
        $isInstallerRoute = $request->is('install') || $request->is('install/*');

        if (!$isInstalled) {
            if (!$isInstallerRoute) {
                return redirect()->route('installer.welcome');
            }
        } else {
            if ($isInstallerRoute) {
                return redirect('/');
            }
        }

        return $next($request);
    }
}
