<?php

namespace App\View\Composers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\View\View;

class FooterComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Get active categories (limit to 4 for footer)
        $footerCategories = Category::active()
            ->whereNull('parent_id')
            ->orderBy('position', 'asc')
            ->take(4)
            ->get();

        // Get contact settings
        $contactInfo = [
            'address' => Setting::get('contact_address', 'Opposite Bangur College, Pali, Rajasthan – 306401'),
            'phone' => Setting::get('contact_phone', '+91 9928154903'),
            'email' => Setting::get('contact_email', 'info@ratannamgold.com'),
            'facebook' => Setting::get('social_facebook', '#'),
            'instagram' => Setting::get('social_instagram', '#'),
            'twitter' => Setting::get('social_twitter', '#'),
        ];

        // Get site settings
        $siteName = Setting::get('site_name', 'Ratannam Gold');
        $siteTagline = Setting::get('site_tagline', 'Crafting timeless elegance. We believe every piece of jewelry tells a story. Discover yours with us.');

        $view->with([
            'footerCategories' => $footerCategories,
            'contactInfo' => $contactInfo,
            'siteName' => $siteName,
            'siteTagline' => $siteTagline
        ]);
    }
}
