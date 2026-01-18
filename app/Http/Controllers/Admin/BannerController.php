<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order', 'asc')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image_path' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'mobile_image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'overlay_opacity' => 'nullable|numeric|min:0|max:1',
            'animate_image' => 'nullable|boolean',
            'show_content_image' => 'nullable|boolean',
            'content_image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'content_position' => 'nullable|in:left,center,right',
            'text_alignment' => 'required|in:left,center,right',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'order' => 'integer',
        ]);

        $data = $request->except(['image_path', 'mobile_image_path', 'content_image_path']);

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('banners', 'public');
            $data['image_path'] = '/storage/' . $path;
        }

        if ($request->hasFile('mobile_image_path')) {
            $path = $request->file('mobile_image_path')->store('banners', 'public');
            $data['mobile_image_path'] = '/storage/' . $path;
        }

        if ($request->hasFile('content_image_path')) {
            $path = $request->file('content_image_path')->store('banners', 'public');
            $data['content_image_path'] = '/storage/' . $path;
        }

        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'mobile_image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'title' => 'nullable|string|max:255',
            'text_alignment' => 'nullable|in:left,center,right',
            'overlay_opacity' => 'nullable|numeric|min:0|max:1',
            'animate_image' => 'nullable|boolean',
            'show_content_image' => 'nullable|boolean',
            'content_image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'content_position' => 'nullable|in:left,center,right',
            'order' => 'integer',
        ]);

        $data = $request->except(['image_path', 'mobile_image_path', 'content_image_path']);

        if ($request->hasFile('image_path')) {
            // Delete old image
            if ($banner->image_path && file_exists(public_path($banner->image_path))) {
                // simple unlink if needed, or Storage::delete
            }
            $path = $request->file('image_path')->store('banners', 'public');
            $data['image_path'] = '/storage/' . $path;
        }

        if ($request->hasFile('mobile_image_path')) {
            $path = $request->file('mobile_image_path')->store('banners', 'public');
            $data['mobile_image_path'] = '/storage/' . $path;
        }

        if ($request->hasFile('content_image_path')) {
            $path = $request->file('content_image_path')->store('banners', 'public');
            $data['content_image_path'] = '/storage/' . $path;
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully.');
    }

    public function toggleActive(Banner $banner)
    {
        $banner->update(['is_active' => !$banner->is_active]);
        return redirect()->back()->with('success', 'Banner status updated.');
    }
}
