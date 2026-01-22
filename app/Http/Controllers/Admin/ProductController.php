<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['categories', 'images']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        if ($request->filled('status')) {
             if($request->status == 'active') $query->where('is_active', true);
             if($request->status == 'inactive') $query->where('is_active', false);
        }

        $products = $query->latest()->paginate(10);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'categories' => 'required|array|min:1',
            'price' => 'required|numeric|min:1',
            'sale_discount' => 'nullable|numeric|min:0|max:100',
            'sku' => 'required|alpha_dash|unique:products,sku',
            'stock_status' => 'nullable|in:instock,outofstock,onbackorder',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:100',
            'weight' => 'nullable|numeric|min:0',
        ]);

        $data = $request->except(['image', 'categories', 'sale_discount']);
        $data['slug'] = Str::slug($request->name) . '-' . Str::random(4);
        $data['is_active'] = $request->has('is_active');
        $data['product_type'] = 'simple'; // Default to simple
        
        // Calculate sale_price from discount percentage
        if ($request->filled('sale_discount') && $request->sale_discount > 0) {
            $data['sale_price'] = $request->price * (1 - ($request->sale_discount / 100));
        } else {
            $data['sale_price'] = null;
        }
        
        $product = Product::create($data);

        // Sync Categories
        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        // Handle Main Image
        if ($request->hasFile('image')) {
             $path = $request->file('image')->store('products', 'public');
             $product->thumbnail = $path;
             $product->save();
             
             ProductImage::create([
                 'product_id' => $product->id,
                 'image_path' => $path,
                 'is_primary' => true
             ]);
        }

        // Handle Variants
        if ($request->has('variants')) {
            foreach($request->variants as $variantData) {
                if(!empty($variantData['sku'])) {
                    $product->variants()->create($variantData);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        $product->load(['categories', 'variants']);
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
          $request->validate([
            'name' => 'required|string|min:3|max:255',
            'categories' => 'required|array|min:1',
            'price' => 'required|numeric|min:1',
            'sale_discount' => 'nullable|numeric|min:0|max:100',
            'sku' => ['required', 'alpha_dash', Rule::unique('products')->ignore($product->id)],
            'stock_status' => 'nullable|in:instock,outofstock,onbackorder',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:100',
            'weight' => 'nullable|numeric|min:0',
        ]);

        $data = $request->except(['image', 'categories', 'sale_discount']);
        $data['is_active'] = $request->has('is_active');
        
        // Calculate sale_price from discount percentage
        if ($request->filled('sale_discount') && $request->sale_discount > 0) {
            $data['sale_price'] = $request->price * (1 - ($request->sale_discount / 100));
        } else {
            $data['sale_price'] = null;
        }

        $product->update($data);

        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        // Update Image
        if ($request->hasFile('image')) {
             if($product->thumbnail) {
                 Storage::disk('public')->delete($product->thumbnail);
             }
             $path = $request->file('image')->store('products', 'public');
             $product->thumbnail = $path;
             $product->save();
             
             $product->images()->where('is_primary', true)->delete();
             ProductImage::create([
                 'product_id' => $product->id,
                 'image_path' => $path,
                 'is_primary' => true
             ]);
        }
        
         // Handle Variants (Update or Create)
        if ($request->has('variants')) {
            foreach($request->variants as $key => $variantData) {
                if(!empty($variantData['id'])) {
                    $variant = ProductVariant::find($variantData['id']);
                    if($variant) $variant->update($variantData);
                } elseif(!empty($variantData['sku'])) {
                    $product->variants()->create($variantData);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // 1. Check for Active Orders (Mock check for now as Order module isn't ready)
        // if ($product->orders()->where('status', 'active')->exists()) {
        //     return back()->with('error', 'Cannot delete product with active orders.');
        // }

        $product->delete(); // Soft Delete
        return redirect()->route('admin.products.index')->with('success', 'Product deleted (archived).');
    }
}
