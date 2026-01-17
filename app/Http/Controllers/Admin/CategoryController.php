<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['parent', 'children', 'products'])->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->with('children')->get();
        return view('admin.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'position' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // 2MB Max
            'icon' => 'nullable|string|max:50',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $data = $request->except('image');
        
        // Ensure unique slug (including trashed)
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (Category::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        $data['slug'] = $slug;

        $data['is_active'] = $request->has('is_active');
        
        if ($request->hasFile('image')) {
             $path = $request->file('image')->store('categories', 'public');
             $data['image'] = $path;
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        // Get all categories except self and children (to prevent cycle) -> Simplified: Logic effectively handled in update
        $categories = Category::whereNull('parent_id')->where('id', '!=', $category->id)->get();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($category) {
                    if ($value == $category->id) {
                        $fail('A category cannot be its own parent.');
                    }
                    // Prevent circular dependency (simplified 1-level check, ideally should check recursive)
                    if ($category->children()->where('id', $value)->exists()) {
                         $fail('Cannot move a category under its own child.');
                    }
                },
            ],
            'position' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'icon' => 'nullable|string|max:50',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $data = $request->except('image');
        
        // Ensure unique slug for update
        if ($category->name != $request->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $count = 1;
            while (Category::withTrashed()->where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            $data['slug'] = $slug;
        }

        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
             if($category->image) {
                 Storage::disk('public')->delete($category->image);
             }
             $path = $request->file('image')->store('categories', 'public');
             $data['image'] = $path;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        // 1. Check Subcategories
        if ($category->children()->count() > 0) {
            return back()->with('error', 'Cannot delete category with active subcategories. Please delete or move them first.');
        }

        // 2. Check Assigned Products
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete category containing products. Please reassign or delete products first.');
        }

        // Soft Delete
        $category->delete();
        
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully (Moved to Trash).');
    }
}
