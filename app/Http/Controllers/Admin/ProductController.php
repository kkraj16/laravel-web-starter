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
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:100',
            'weight' => 'nullable|numeric|min:0',
        ]);

        $data = $request->except(['images', 'categories', 'sale_discount']);
        $data['slug'] = Str::slug($request->name) . '-' . Str::random(4);
        $data['is_active'] = $request->has('is_active');
        $data['is_trending'] = $request->has('is_trending');
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
        // Handle Images (Multiple)
        if ($request->hasFile('images')) {
            foreach($request->file('images') as $index => $file) {
                $path = $file->store('products', 'public');
                
                // If it's the first image, set as thumbnail if not already set
                if ($index === 0) {
                    $product->thumbnail = $path;
                    $product->save();
                }

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => ($index === 0)
                ]);
            }
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
            'new_images' => 'nullable|array',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'delete_image_ids' => 'nullable|array',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:100',
            'weight' => 'nullable|numeric|min:0',
        ]);

        $data = $request->except(['new_images', 'delete_image_ids', 'categories', 'sale_discount']);
        $data['is_active'] = $request->has('is_active');
        $data['is_trending'] = $request->has('is_trending');
        
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
        // Handle New Images
        if ($request->hasFile('new_images')) {
             foreach($request->file('new_images') as $file) {
                $path = $file->store('products', 'public');
                
                // If product has no thumbnail, set this one
                if (!$product->thumbnail) {
                    $product->thumbnail = $path;
                    $product->save();
                }

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => false
                ]);
             }
        }

        // Handle Image Deletion
        if ($request->filled('delete_image_ids')) {
            $imagesToDelete = ProductImage::whereIn('id', $request->delete_image_ids)
                                          ->where('product_id', $product->id)
                                          ->get();
            
            foreach($imagesToDelete as $img) {
                // Determine if we need to update product thumbnail
                $isThumbnail = ($product->thumbnail === $img->image_path);

                Storage::disk('public')->delete($img->image_path);
                $img->delete();

                if ($isThumbnail) {
                    $nextImage = $product->images()->first();
                    $product->thumbnail = $nextImage ? $nextImage->image_path : null;
                    $product->save();
                    
                    if($nextImage) {
                        $nextImage->update(['is_primary' => true]);
                    }
                }
            }
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
