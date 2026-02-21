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
     *
     * All seeders are idempotent (safe to re-run).
     * Order matters: Roles → Users → Settings → Categories → Testimonials.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,  // Roles & Permissions (required first)
            UserSeeder::class,            // Admin account
            SettingsSeeder::class,        // Site configuration defaults
            CategorySeeder::class,        // Product categories
            TestimonialSeeder::class,     // Initial testimonials
        ]);

        // Dev / Demo seeders — only run in local or testing
        if (app()->isLocal() || app()->runningUnitTests()) {
            $this->call([
                DemoDataSeeder::class,
            ]);
        }
    }
}
