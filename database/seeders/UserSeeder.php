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
        // Production Admin Account
        $admin = User::firstOrCreate(
            ['email' => 'admin@ratannam.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('RatannamAdmin@2026'),
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        $this->assignRole($admin, 'Super Admin');
    }

    private function assignRole(User $user, string $roleName): void
    {
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            return;
        }

        $exists = DB::table('model_has_roles')
            ->where('role_id', $role->id)
            ->where('model_type', User::class)
            ->where('model_id', $user->id)
            ->exists();

        if (!$exists) {
            DB::table('model_has_roles')->insert([
                'role_id' => $role->id,
                'model_type' => User::class,
                'model_id' => $user->id,
            ]);
        }
    }
}
