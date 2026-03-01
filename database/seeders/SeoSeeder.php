<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SeoMeta;

class SeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Home Page SEO
        SeoMeta::updateOrCreate(
            ['route_name' => 'home'],
            [
                'page_path' => '/',
                'meta_title' => 'Ratannam Gold | Luxury BIS Hallmarked Gold & Diamond Jewellery in Pali',
                'meta_description' => 'Discover the finest 22K BIS Hallmarked gold jewellery at Ratannam Gold, Pali. Exclusive bridal collections, designer necklaces, and Rajputana heritage jewellery. Purity guaranteed since 1994.',
                'meta_keywords' => 'Ratannam Gold Pali, 22K Hallmarked Gold, Bridal Jewellery Rajasthan, Diamond Jewellery Pali, KK Rajpurohit Jewellers, Traditional Rajasthani Jewellery, Gold Shop near me',
                'og_title' => 'Ratannam Gold | Premium Jewellery & Heritage Collections',
                'og_description' => 'Experience the artistry of traditional and modern gold jewellery. 100% BIS Hallmarked pieces handcrafted for the modern bride.',
                'og_image' => 'uploads/seo/home-og.jpg',
                'robots' => 'index, follow',
                'canonical_url' => url('/'),
            ]
        );

        // 2. About Page SEO
        SeoMeta::updateOrCreate(
            ['route_name' => 'about'],
            [
                'page_path' => '/about',
                'meta_title' => 'Our Heritage | Ratannam Gold - Legacy of Purity & Trust Since 1994',
                'meta_description' => 'Founded by KK Rajpurohit, Ratannam Gold is a name synonymous with 916 purity and artistic excellence in Pali, Rajasthan. Experience three decades of handcrafted luxury.',
                'meta_keywords' => 'Ratannam Gold Story, KK Rajpurohit, History of Ratannam Gold, Trusted Jewellers Pali, Traditional Rajasthani Craftsmanship, Gold Purity 916',
                'og_title' => 'The Legacy of Ratannam Gold',
                'og_description' => 'A tradition of trust and artistic brilliance. Learn about our journey in crafting perfection for over 30 years.',
                'robots' => 'index, follow',
                'canonical_url' => url('/about'),
            ]
        );

        // 3. Contact Page SEO
        SeoMeta::updateOrCreate(
            ['route_name' => 'contact'],
            [
                'page_path' => '/contact',
                'meta_title' => 'Visit Us | Ratannam Gold Showroom in Pali - Expert Consultations',
                'meta_description' => 'Visit our luxury boutique in Pali, Rajasthan for exclusive designs. Contact our experts for custom bridal sets and live gold market rates.',
                'meta_keywords' => 'Ratannam Gold Location, Jewellery Shop Pali Rajasthan, Custom Jewellery Orders, Gold Rate Pali, Visit Ratannam Gold Showroom, KK Rajpurohit Contact',
                'og_title' => 'Reach Out to Ratannam Gold Pali',
                'og_description' => 'Book a private consultation or visit our boutique. We are here to help you find your next heirloom.',
                'robots' => 'index, follow',
                'canonical_url' => url('/contact'),
            ]
        );

        // 4. Category SEO (Dynamic Content)
        $categories = [
            'gold-jewellery' => [
                'title' => 'Gold Jewellery Collection | 22K BIS Hallmarked | Ratannam Gold',
                'desc' => 'Explore our stunning range of 22K gold jewellery. From traditional kundan to modern lightweight designs, find the perfect piece for every celebration.',
                'keys' => '22k gold jewellery, hallmarked gold, gold ornaments, traditional gold designs, modern gold jewellery'
            ],
            'silver-jewellery' => [
                'title' => 'Fine Silver Jewellery & Articles | Pure Silver | Ratannam Gold',
                'desc' => 'Discover elegant silver jewellery and ceremonial articles. High-purity silver ornaments handcrafted with precision and care.',
                'keys' => 'silver jewellery, pure silver articles, silver ornaments, silver gifts, handcrafted silver'
            ],
            'bridal-jewellery' => [
                'title' => 'Exquisite Bridal Jewellery | Wedding Collection | Ratannam Gold',
                'desc' => 'Make your big day unforgettable with our royal bridal collection. Heavy kundan sets, temple jewellery, and designer bridal ornaments in 22K gold.',
                'keys' => 'bridal gold jewellery, wedding jewellery set, kundan bridal set, temple jewellery, wedding gold ornaments'
            ],
            'gold-rings' => [
                'title' => 'Designer Gold Rings | Wedding, Engagement & Daily Wear | Ratannam Gold',
                'desc' => 'Find the perfect ring for every finger. Browse our collection of engagement rings, wedding bands, and daily wear gold rings in unique designs.',
                'keys' => 'gold rings, engagement rings, gold wedding bands, ladies gold rings, mens gold rings'
            ]
        ];

        foreach ($categories as $slug => $seo) {
            $cat = \App\Models\Category::where('slug', $slug)->first();
            if ($cat) {
                $cat->seoMeta()->updateOrCreate(
                    [],
                    [
                        'meta_title' => $seo['title'],
                        'meta_description' => $seo['desc'],
                        'meta_keywords' => $seo['keys'],
                        'og_title' => $seo['title'],
                        'og_description' => $seo['desc'],
                        'robots' => 'index, follow',
                        'canonical_url' => url('/category/' . $slug),
                    ]
                );
            }
        }
    }
}
