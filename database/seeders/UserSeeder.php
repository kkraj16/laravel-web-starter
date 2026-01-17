<?php

namespace Database\Seeders;

use App\Core\RBAC\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        $user = User::firstOrCreate(
            ['email' => 'admin@ratannam.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        $this->assignRole($user, 'Super Admin');

        // Manager
        $manager = User::firstOrCreate(
            ['email' => 'manager@ratannam.com'],
            [
                'name' => 'Store Manager',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );
        
        $this->assignRole($manager, 'Manager');

        // Customer
        $customer = User::firstOrCreate(
            ['email' => 'customer@ratannam.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        $this->assignRole($customer, 'Customer');
    }

    private function assignRole($user, $roleName)
    {
        $role = Role::where('name', $roleName)->first();
        if($role) {
            // Check if already assigned to avoid duplicates
            $exists = DB::table('model_has_roles')
                ->where('role_id', $role->id)
                ->where('model_type', User::class)
                ->where('model_id', $user->id)
                ->exists();
            
            if (!$exists) {
                DB::table('model_has_roles')->insert([
                    'role_id' => $role->id,
                    'model_type' => User::class,
                    'model_id' => $user->id
                ]);
            }
        }
    }
}
