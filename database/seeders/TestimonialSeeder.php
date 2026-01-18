<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run()
    {
        // Clear existing to avoid duplicates if re-run
        Testimonial::truncate();

        $testimonials = [
            [
                'name' => 'Anjali Gupta',
                'content' => 'Beautiful designs and very transparent pricing. I loved the transparency with the live rates. Will visit again.',
                'rating' => 5,
                'is_active' => true,
                'review_date' => now()->subDays(2),
            ],
            [
                'name' => 'Rahul Verma',
                'content' => 'Excellent service and genuine quality. The staff was very helpful in helping me choose the perfect ring for my wife.',
                'rating' => 5,
                'is_active' => true,
                'review_date' => now()->subDays(5),
            ],
            [
                'name' => 'Priya Sharma',
                'content' => 'Absolutely stunning craftsmanship! The gold necklace I purchased for my wedding was the highlight of my jewelry collection. Highly recommended.',
                'rating' => 5,
                'is_active' => true,
                'review_date' => now()->subDays(10),
            ],
            [
                'name' => 'Amit Singhania',
                'content' => 'Ratannam Gold is my go-to for investment gold. Their purity is guaranteed and the buy-back policies are very fair.',
                'rating' => 4,
                'is_active' => true,
                'review_date' => now()->subDays(15),
            ],
            [
                'name' => 'Suman Rathore',
                'content' => 'I ordered a custom bangle set and it turned out exactly how I imagined. The detailing is exquisite. Thank you!',
                'rating' => 5,
                'is_active' => true,
                'review_date' => now()->subDays(20),
            ],
            [
                'name' => 'Vikram Singh',
                'content' => 'Best jewellery showroom in Pali. The variety of designs in both gold and silver is amazing. Very polite staff.',
                'rating' => 5,
                'is_active' => true,
                'review_date' => now()->subDays(25),
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
