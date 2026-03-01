<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->latest()->get();
        $categories = Category::where('is_active', true)->get();

        $content = view('themes.default.sitemap', compact('products', 'categories'))->render();

        return Response::make($content, 200, [
            'Content-Type' => 'application/xml'
        ]);
    }
}
