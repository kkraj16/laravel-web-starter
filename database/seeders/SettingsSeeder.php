<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Ratannam Gold', 'group' => 'general', 'type' => 'string'],
            ['key' => 'site_logo', 'value' => '/images/logo.png', 'group' => 'general', 'type' => 'string'],
            ['key' => 'contact_email', 'value' => 'info@ratannam.com', 'group' => 'general', 'type' => 'string'],
            ['key' => 'currency_symbol', 'value' => '₹', 'group' => 'finance', 'type' => 'string'],
            ['key' => 'active_theme', 'value' => 'default', 'group' => 'theme', 'type' => 'string'],
        ];

        DB::table('settings')->insert($settings);
    }
}
