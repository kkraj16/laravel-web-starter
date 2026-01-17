<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Gold Jewellery',
                'slug' => 'gold-jewellery',
                'icon' => 'bi bi-gem',
                'description' => 'Exquisite 22k and 18k gold jewellery collections.',
                'image' => null, // Placeholder or null
            ],
            [
                'name' => 'Silver Jewellery',
                'slug' => 'silver-jewellery',
                'icon' => 'bi bi-stars',
                'description' => 'Premium sterling silver accessories.',
                'image' => null,
            ],
            [
                'name' => 'Bridal Jewellery',
                'slug' => 'bridal-jewellery',
                'icon' => 'bi bi-heart-fill',
                'description' => 'Complete bridal sets for your special day.',
                'image' => null,
            ],
            [
                'name' => 'Daily Wear Jewellery',
                'slug' => 'daily-wear-jewellery',
                'icon' => 'bi bi-sun',
                'description' => 'Lightweight and stylish jewellery for everyday elegance.',
                'image' => null,
            ],
            [
                'name' => 'Men & Kids',
                'slug' => 'men-kids',
                'icon' => 'bi bi-people',
                'description' => 'Exclusive collections for men and children.',
                'image' => null,
            ],
            [
                'name' => 'Coins & Gifts',
                'slug' => 'coins-gifts',
                'icon' => 'bi bi-coin',
                'description' => 'Gold/Silver coins and gifting articles.',
                'image' => null,
            ],
        ];

        foreach ($categories as $index => $cat) {
            Category::updateOrCreate(
                ['slug' => $cat['slug']],
                [
                    'name' => $cat['name'],
                    'icon' => $cat['icon'],
                    'description' => $cat['description'],
                    'position' => $index,
                    'is_active' => true,
                    'meta_title' => $cat['name'] . ' - Ratannam Gold',
                    'meta_description' => $cat['description'],
                ]
            );
        }
    }
}
