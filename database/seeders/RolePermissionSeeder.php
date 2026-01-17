<?php

namespace Database\Seeders;

use App\Core\RBAC\Models\Permission;
use App\Core\RBAC\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Illuminate\Cache\CacheManager::class]->forget('spatie.permission.cache');

        // Create Permissions
        $modules = [
            'product', 'category', 'order', 'customer', 'review', 'banner', 'user', 'role', 'settings'
        ];
        
        $actions = ['view', 'create', 'edit', 'delete'];

        $permissions = [];
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permissions[] = "{$module}.{$action}";
            }
        }

        // Additional specific permissions
        $permissions[] = 'dashboard.view';
        $permissions[] = 'media.upload';

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles and Assign Permissions
        
        // Super Admin
        $superAdmin = Role::create(['name' => 'Super Admin']);
        // Super Admin gets all permissions bypass logic usually, but we can also assign all
        $allPermissions = Permission::all();
        $superAdmin->permissions()->sync($allPermissions);

        // Manager
        $manager = Role::create(['name' => 'Manager']);
        $managerPermissions = Permission::whereIn('group_name', ['product', 'category', 'order', 'review', 'banner'])
                                       ->orWhere('name', 'dashboard.view')
                                       ->get();
        // Since we didn't set group_name in the loop above, let's filter by name
        // Ideally we should have set group_name. Let's rely on name filtering.
        $managerPermissions = Permission::where(function($query) {
            $query->where('name', 'like', 'product.%')
                  ->orWhere('name', 'like', 'category.%')
                  ->orWhere('name', 'like', 'order.%')
                  ->orWhere('name', 'like', 'review.%')
                  ->orWhere('name', 'like', 'banner.%')
                  ->orWhere('name', 'dashboard.view');
        })->get();
        
        $manager->permissions()->sync($managerPermissions);

        // Admin (below Super Admin, maybe no Settings/Role access?)
        $admin = Role::create(['name' => 'Admin']);
        $adminPermissions = Permission::where('name', 'not like', 'role.%')
                                      ->where('name', '!=', 'settings.delete') // Example restriction
                                      ->get();
        $admin->permissions()->sync($adminPermissions);

        // Customer
        Role::create(['name' => 'Customer']);
    }
}
