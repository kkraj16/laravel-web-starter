<?php

namespace App\Http\View\Composers;

use App\Models\SeoMeta;
use App\Models\Setting;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;

class SeoComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        $seo = null;
        $viewData = $view->getData();

        // 1. Priority: Model-specific SEO (Product or Category)
        /* 
         * Temporarily disabled product SEO for production
         *
        if (isset($viewData['product']) && method_exists($viewData['product'], 'seoMeta')) {
            $seo = $viewData['product']->seoMeta;
            
            // Inject product image if og_image is missing
            if ($seo && empty($seo->og_image)) {
                $seo->og_image = $viewData['product']->primary_image;
            }
        } else
        */
        if (isset($viewData['category']) && method_exists($viewData['category'], 'seoMeta')) {
            $seo = $viewData['category']->seoMeta;

            // Inject category image if og_image is missing
            if ($seo && empty($seo->og_image) && $viewData['category']->image) {
                // Ensure the path is fully qualified or absolute for OG tags
                $imagePath = $viewData['category']->image;
                $seo->og_image = str_starts_with($imagePath, 'http') ? $imagePath : asset('storage/' . $imagePath);
            }
        }

        // 2. Secondary: Route-specific SEO (Home, About, Contact)
        if (!$seo) {
            $routeName = Route::currentRouteName();
            if ($routeName) {
                $seo = SeoMeta::where('route_name', $routeName)->first();
            }
        }

        // 3. Fallback: Path-specific SEO
        if (!$seo) {
            $path = '/' . ltrim(request()->path(), '/');
            $seo = SeoMeta::where('page_path', $path)->first();
        }

        // 4. Ultimate Fallback: Global Settings
        if (!$seo) {
            $seo = new SeoMeta([
                'meta_title' => Setting::get('site_title', config('app.name')),
                'meta_description' => Setting::get('seo_description'),
                'meta_keywords' => Setting::get('seo_keywords'),
                'og_title' => Setting::get('site_title', config('app.name')),
                'og_description' => Setting::get('seo_description'),
                'robots' => 'index, follow'
            ]);
        }

        $view->with('seo', $seo);
    }
}
