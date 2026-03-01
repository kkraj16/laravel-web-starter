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
        if (isset($viewData['product']) && method_exists($viewData['product'], 'seoMeta')) {
            $seo = $viewData['product']->seoMeta;
        } elseif (isset($viewData['category']) && method_exists($viewData['category'], 'seoMeta')) {
            $seo = $viewData['category']->seoMeta;
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
