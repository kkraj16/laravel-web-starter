<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'productsCount' => Product::count(),
            'categoriesCount' => Category::count(),
            'testimonialsCount' => Testimonial::count(),
        ];
        
        return view('admin.dashboard.index', $data);
    }
}
