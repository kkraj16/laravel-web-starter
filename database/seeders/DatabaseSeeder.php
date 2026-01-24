<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Essential Production Seeders
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            SettingsSeeder::class,
            CategorySeeder::class, // Defaults (Gold, Silver, etc.)
        ]);

        // Optional / Demo Data (Skip in Production)
        if (app()->isLocal() || app()->runningUnitTests()) {
            $this->call([
                DemoDataSeeder::class,
                // ProductSqlSeeder::class, // Uncomment if you have a SQL dump seeder
            ]);
        }
    }
}
