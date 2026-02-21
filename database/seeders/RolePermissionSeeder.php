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

        // Define Permissions
        $modules = [
            'product', 'category', 'order', 'customer',
            'review', 'banner', 'testimonial', 'user',
            'role', 'settings',
        ];

        $actions = ['view', 'create', 'edit', 'delete'];

        $permissions = [];
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permissions[] = "{$module}.{$action}";
            }
        }

        // Additional permissions
        $permissions[] = 'dashboard.view';
        $permissions[] = 'media.upload';

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles (idempotent)
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $admin      = Role::firstOrCreate(['name' => 'Admin']);
        $manager    = Role::firstOrCreate(['name' => 'Manager']);
        Role::firstOrCreate(['name' => 'Customer']);

        // Assign Permissions

        // Super Admin → ALL permissions
        $superAdmin->permissions()->sync(Permission::all());

        // Admin → Everything except role management and settings.delete
        $admin->permissions()->sync(
            Permission::where('name', 'not like', 'role.%')
                      ->where('name', '!=', 'settings.delete')
                      ->get()
        );

        // Manager → Products, Categories, Orders, Reviews, Banners, Testimonials + Dashboard
        $manager->permissions()->sync(
            Permission::where(function ($query) {
                $query->where('name', 'like', 'product.%')
                      ->orWhere('name', 'like', 'category.%')
                      ->orWhere('name', 'like', 'order.%')
                      ->orWhere('name', 'like', 'review.%')
                      ->orWhere('name', 'like', 'banner.%')
                      ->orWhere('name', 'like', 'testimonial.%')
                      ->orWhere('name', '=', 'dashboard.view')
                      ->orWhere('name', '=', 'media.upload');
            })->get()
        );

        // Customer → No admin permissions (role only, no panel access)
    }
}
