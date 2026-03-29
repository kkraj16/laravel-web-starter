<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->where('is_active', true);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Filter by Category (supports both slug and ID array)
        if ($request->has('category') && $request->category != '') {
            // Single category by slug (from footer links)
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.slug', $request->category);
            });
        } elseif ($request->has('categories') && is_array($request->categories)) {
            // Multiple categories by IDs (from filter sidebar)
            $categoryIds = $request->categories;
            $query->whereHas('categories', function($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds)
                  ->orWhereIn('categories.parent_id', $categoryIds);
            });
        }


        // Filter by Price Range
        $hidePrices = \App\Models\Setting::get('hide_prices', 0);
        if (!$hidePrices) {
            if ($request->has('min_price') && $request->min_price != '') {
                $query->where('price', '>=', $request->min_price);
            }
            if ($request->has('max_price') && $request->max_price != '') {
                $query->where('price', '<=', $request->max_price);
            }
        }

        // Filter by Material
        if ($request->has('materials') && is_array($request->materials)) {
            $query->whereIn('material', $request->materials);
        }

        // Filter by Purity
        if ($request->has('purities') && is_array($request->purities)) {
            $query->whereIn('purity', $request->purities);
        }

        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                case 'price-asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                case 'price-desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                case 'name_asc':
                case 'name-asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                case 'name-desc':
                    $query->orderBy('name', 'desc');
                    break;
                default:
                    $query->latest(); // Default sort
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        
        $categories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->with(['children' => function($q) {
                $q->where('is_active', true)
                  ->withCount('products')
                  ->orderBy('position', 'asc');
            }])
            ->withCount('products')
            ->orderBy('position', 'asc')
            ->get();
        
        $minPrice = Product::min('price') ?? 0;
        $maxPrice = Product::max('price') ?? 10000;
        
        // Get distinct materials and purities for filter buttons
        $materials = Product::distinct()->pluck('material')->filter()->values();
        $purities = Product::distinct()->pluck('purity')->filter()->values();

        // Pass selected category slug for highlighting
        $selectedCategorySlug = $request->get('category', null);
        
        // Get selected category ID if slug is provided
        $selectedCategoryId = null;
        if ($selectedCategorySlug) {
            $selectedCategory = Category::where('slug', $selectedCategorySlug)->first();
            $selectedCategoryId = $selectedCategory ? $selectedCategory->id : null;
        }

        return view('themes.default.products.index', compact(
            'products', 
            'categories', 
            'minPrice', 
            'maxPrice', 
            'materials', 
            'purities',
            'selectedCategorySlug',
            'selectedCategoryId',
            'hidePrices'
        ));
    }
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->orWhere('id', $slug)
            ->where('is_active', true)
            ->with(['categories', 'images'])
            ->firstOrFail();

        return view('themes.default.products.show', compact('product'));
    }
}
