<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General / Branding
            ['key' => 'site_name',    'value' => 'Ratannam Gold', 'group' => 'general', 'type' => 'string'],
            ['key' => 'site_tagline', 'value' => 'Crafting timeless elegance since generations.', 'group' => 'general', 'type' => 'string'],
            ['key' => 'site_logo',    'value' => '/images/logo.png', 'group' => 'general', 'type' => 'string'],
            ['key' => 'active_theme', 'value' => 'default', 'group' => 'general', 'type' => 'string'],

            // Contact Information
            ['key' => 'contact_email',     'value' => 'info@ratannamgold.com',    'group' => 'contact', 'type' => 'string'],
            ['key' => 'contact_phone',     'value' => '+91 9928154903',           'group' => 'contact', 'type' => 'string'],
            ['key' => 'store_phone',       'value' => '+91 9928154903',           'group' => 'contact', 'type' => 'string'],
            ['key' => 'contact_whatsapp',  'value' => '919928154903',             'group' => 'contact', 'type' => 'string'],
            ['key' => 'contact_address',   'value' => 'Opposite Bangur College, Pali, Rajasthan – 306401', 'group' => 'contact', 'type' => 'string'],

            // Map
            ['key' => 'map_coordinates',   'value' => '25.7711,73.3234',          'group' => 'contact', 'type' => 'string'],
            ['key' => 'google_map_embed',  'value' => '',                          'group' => 'contact', 'type' => 'string'],

            // Social Media
            ['key' => 'social_facebook',  'value' => '#', 'group' => 'social', 'type' => 'string'],
            ['key' => 'social_instagram', 'value' => '#', 'group' => 'social', 'type' => 'string'],
            ['key' => 'social_twitter',   'value' => '#', 'group' => 'social', 'type' => 'string'],

            // Finance / Display
            ['key' => 'currency_symbol',    'value' => '₹',  'group' => 'finance', 'type' => 'string'],
            ['key' => 'hide_prices',        'value' => '0',  'group' => 'finance', 'type' => 'boolean'],
            ['key' => 'show_gold_prices',   'value' => '1',  'group' => 'finance', 'type' => 'boolean'],
            ['key' => 'show_silver_prices', 'value' => '1',  'group' => 'finance', 'type' => 'boolean'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
