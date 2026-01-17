<?php

namespace App\Core\RBAC;

use App\Core\RBAC\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class RBACServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        try {
            // Bypass for Super Admin
            Gate::before(function ($user, $ability) {
                if ($user->hasRole('Super Admin')) {
                    return true;
                }
            });

            // Define Gates dynamically
            // Check if tables exist first to avoid errors during initial migration
            if (\Illuminate\Support\Facades\Schema::hasTable('permissions')) {
                foreach (Permission::all() as $permission) {
                    Gate::define($permission->name, function ($user) use ($permission) {
                        return $user->hasPermissionTo($permission->name);
                    });
                }
            }
        } catch (\Exception $e) {
            Log::error('RBAC Gate registration failed: ' . $e->getMessage());
        }
    }
}
