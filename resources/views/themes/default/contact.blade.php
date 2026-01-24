@extends('theme::layouts.app')

@section('content')

<!-- Hero Section -->
<div class="relative py-24 bg-black flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 opacity-40 bg-cover bg-center" style="background-image: url('{{ asset('images/banner/banner-background.jpg') }}');"></div>
    <div class="relative z-10 text-center text-white px-4">
        <h6 class="text-primary tracking-[0.3em] uppercase text-xs mb-3">Personal Assistance</h6>
        <h1 class="font-serif text-4xl md:text-5xl mb-4">Contact Us</h1>
        <p class="text-gray-400 text-sm font-light max-w-lg mx-auto leading-relaxed">
            Whether you're looking for a bespoke bridal set or have a simple query about gold rates, our experts are here to help you.
        </p>
    </div>
</div>

<section class="bg-gray-50 py-20 relative">
    <div class="container mx-auto px-6">
        <div class="bg-white shadow-xl rounded-none overflow-hidden flex flex-col md:flex-row">
            
            <!-- Left Info Panel -->
            <div class="w-full md:w-1/3 p-10 md:p-12 flex flex-col justify-center">
                <h3 class="font-serif text-2xl mb-8 text-gray-900 border-b border-gray-100 pb-4">Our Flagship Boutique</h3>
                
                <div class="space-y-8">
                    <!-- Address -->
                    <div class="flex items-start group">
                        <div class="w-10 h-10 rounded-full bg-orange-50 text-primary flex items-center justify-center flex-shrink-0 mt-1 transition-colors group-hover:bg-primary group-hover:text-white">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div class="ml-4">
                            <span class="block text-[10px] tracking-widest uppercase text-gray-400 mb-1">Visit Us</span>
                            <p class="text-sm font-medium text-gray-800 leading-relaxed">
                                {!! nl2br(e($contactInfo['address'] ?? 'Opposite Bangur College, Pali, Rajasthan – 306401')) !!}
                            </p>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="flex items-start group">
                        <div class="w-10 h-10 rounded-full bg-orange-50 text-primary flex items-center justify-center flex-shrink-0 mt-1 transition-colors group-hover:bg-primary group-hover:text-white">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div class="ml-4">
                            <span class="block text-[10px] tracking-widest uppercase text-gray-400 mb-1">Call Support</span>
                            <p class="text-sm font-medium text-gray-800">{{ $contactInfo['phone'] ?? '+91 9928154903' }}</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start group">
                         <div class="w-10 h-10 rounded-full bg-orange-50 text-primary flex items-center justify-center flex-shrink-0 mt-1 transition-colors group-hover:bg-primary group-hover:text-white">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="ml-4">
                            <span class="block text-[10px] tracking-widest uppercase text-gray-400 mb-1">Write To Us</span>
                            <p class="text-sm font-medium text-gray-800">{{ $contactInfo['email'] ?? 'info@ratannamgold.com' }}</p>
                        </div>
                    </div>

                    <!-- Hours -->
                    <div class="flex items-start group">
                         <div class="w-10 h-10 rounded-full bg-orange-50 text-primary flex items-center justify-center flex-shrink-0 mt-1 transition-colors group-hover:bg-primary group-hover:text-white">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div class="ml-4">
                            <span class="block text-[10px] tracking-widest uppercase text-gray-400 mb-1">Store Hours</span>
                            <p class="text-sm font-medium text-gray-800">Mon - Sun: 10:30 AM - 8:30 PM</p>
                        </div>
                    </div>
                </div>

                <!-- Inquiry Box -->
                <div class="mt-12 bg-orange-50 p-6 rounded border border-orange-100">
                    <h4 class="font-serif text-lg italic text-gray-900 mb-2">Immediate Inquiry?</h4>
                    <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                        Message us on WhatsApp for instant assistance with pricing, customizations, or booking a visit.
                    </p>
                    <!-- Mobile: Button -->
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactInfo['whatsapp'] ?? '919928154903') }}" target="_blank" class="md:hidden block w-full bg-[#25D366] hover:bg-[#20b85a] text-white text-center py-3 text-xs font-bold tracking-widest uppercase rounded transition-colors shadow-lg shadow-green-100">
                        <i class="bi bi-whatsapp mr-2 text-lg align-middle"></i> Start Chat
                    </a>

                    <!-- Desktop: QR Code -->
                    <div class="hidden md:flex flex-col items-center justify-center text-center">
                        <canvas id="qr-whatsapp" class="border p-2 bg-white rounded shadow-sm mb-2"></canvas>
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Scan to Chat</p>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            new QRious({
                                element: document.getElementById('qr-whatsapp'),
                                value: 'https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactInfo['whatsapp'] ?? '919928154903') }}',
                                size: 120
                            });
                        });
                    </script>
                </div>
            </div>

            <!-- Map -->
            <div class="w-full md:w-2/3 bg-gray-200 min-h-[400px]">
                @php
                    // Generate map URL from coordinates if available, otherwise use custom embed URL
                    $mapUrl = '';
                    if (!empty($contactInfo['map_coordinates'])) {
                        // Parse coordinates (format: "latitude, longitude" or "latitude,longitude")
                        $coords = explode(',', str_replace(' ', '', $contactInfo['map_coordinates']));
                        if (count($coords) == 2) {
                            $lat = trim($coords[0]);
                            $lng = trim($coords[1]);
                            $mapUrl = "https://www.google.com/maps?q={$lat},{$lng}&z=15&output=embed";
                        }
                    }
                    
                    // Fallback to custom embed URL if coordinates not set
                    if (empty($mapUrl)) {
                        $mapUrl = $contactInfo['google_map_embed'] ?? 'https://www.google.com/maps/embed?pb=...';
                    }
                @endphp
                
                <iframe 
                    src="{{ $mapUrl }}" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy"
                    class="grayscale hover:grayscale-0 transition-all duration-700">
                </iframe>
            </div>
        </div>
    </div>
</section>

<!-- Corporate Gifting -->
<section class="py-20 bg-white text-center">
    <div class="container mx-auto px-6">
        <h2 class="font-serif text-3xl mb-4">Corporate & Gifting</h2>
        <p class="text-gray-400 text-sm max-w-2xl mx-auto leading-relaxed">
            We offer specialized services for corporate gifting and bulk silver coin orders. Please reach out to our team at <a href="mailto:{{ $contactInfo['email'] ?? 'info@ratannamgold.com' }}" class="text-primary hover:underline">{{ $contactInfo['email'] ?? 'info@ratannamgold.com' }}</a> for custom catalogues and pricing.
        </p>
    </div>
</section>

@endsection
