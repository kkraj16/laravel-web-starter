<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private function getSettings()
    {
        return Setting::all()->pluck('value', 'key');
    }

    public function index()
    {
        return redirect()->route('admin.settings.contact');
    }

    public function contact()
    {
        $settings = $this->getSettings();
        return view('admin.settings.contact', compact('settings'));
    }

    public function seo()
    {
        $settings = $this->getSettings();
        return view('admin.settings.seo', compact('settings'));
    }

    public function markets()
    {
        $settings = $this->getSettings();
        return view('admin.settings.markets', compact('settings'));
    }

    public function globalConfig()
    {
        $settings = $this->getSettings();
        return view('admin.settings.global', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        // Handle Checkboxes (boolean fields)
        // If 'hide_prices' is not in the request, it means it was unchecked.
        if (!$request->has('hide_prices')) {
            Setting::set('hide_prices', 0, 'general', 'boolean');
        }

        // Handle File Uploads
        if ($request->hasFile('site_logo')) {
            $request->validate(['site_logo' => 'image|mimes:jpeg,png,jpg,svg|max:2048']);
            $file = $request->file('site_logo');
            $filename = 'logo.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/system'), $filename);
            
            // Set the URL path for the database
            $data['site_logo_url'] = 'uploads/system/' . $filename;
            unset($data['site_logo']); // Don't save the file object as a setting
        }

        if ($request->hasFile('site_favicon')) {
            $request->validate(['site_favicon' => 'mimes:ico,png,jpg,svg|max:1024']);
            $file = $request->file('site_favicon');
            $filename = 'favicon.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/system'), $filename);

            // Set the URL path for the database
            $data['site_favicon_url'] = 'uploads/system/' . $filename;
            unset($data['site_favicon']); // Don't save the file object as a setting
        }

        foreach ($data as $key => $value) {
            // Skip if value is a file object (redundant safety)
            if ($value instanceof \Illuminate\Http\UploadedFile) continue;

            $group = 'general';
            $type = 'string';

            // Determine Group & Type based on key prefix or name
            if (str_starts_with($key, 'rate_')) {
                $group = 'rates';
                $type = 'number';
            } elseif (str_starts_with($key, 'seo_') || $key == 'site_title') {
                $group = 'seo';
            } elseif ($key == 'hide_prices') {
                $type = 'boolean';
                $value = 1; // It's present, so it's true
            } elseif ($key == 'app_name' || $key == 'site_logo_url' || $key == 'site_favicon_url') {
                $group = 'global';
            }

            Setting::set($key, $value, $group, $type);
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
    
    public function updateRates(Request $request)
    {
         $request->validate([
            'rate_gold_24k' => 'nullable|numeric',
            'rate_gold_22k' => 'nullable|numeric',
            'rate_silver' => 'nullable|numeric',
        ]);

        Setting::set('rate_gold_24k', $request->rate_gold_24k, 'rates', 'number');
        Setting::set('rate_gold_22k', $request->rate_gold_22k, 'rates', 'number');
        Setting::set('rate_silver', $request->rate_silver, 'rates', 'number');

        return redirect()->back()->with('success', 'Live rates updated successfully.');
    }
}
