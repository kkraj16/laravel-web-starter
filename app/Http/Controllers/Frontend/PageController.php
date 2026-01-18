<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function contact()
    {
        $contactInfo = [
            'phone' => Setting::get('store_phone'),
            'whatsapp' => Setting::get('contact_whatsapp'),
            'email' => Setting::get('contact_email'),
            'address' => Setting::get('contact_address'),
            'map_coordinates' => Setting::get('map_coordinates'),
            'google_map_embed' => Setting::get('google_map_embed'),
        ];

        return view('theme::contact', compact('contactInfo'));
    }

    public function about()
    {
        return view('theme::about');
    }
}
