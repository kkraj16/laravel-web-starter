@extends('theme::layouts.app')

@section('content')

<!-- Hero Section -->
<!-- Hero Section -->
<div class="relative py-20 bg-black flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 opacity-40 bg-cover bg-center" style="background-image: url('{{ asset('images/banner/banner-background.jpg') }}');"></div>
    <div class="relative z-10 text-center text-white px-4">
        <span class="text-xs font-bold tracking-[0.3em] uppercase text-primary mb-3 block">Timeless Elegance</span>
        <h1 class="font-serif text-4xl md:text-5xl mb-4">Our Story</h1>
        <div class="w-12 h-0.5 bg-primary mx-auto mb-1"></div>
        <p class="text-gray-300 max-w-lg mx-auto text-sm leading-relaxed font-light">
            Discover the heritage of Ratannam Gold. A journey of trust, purity, and exquisite craftsmanship that defines our legacy in fine jewellery.
        </p>
    </div>
</div>

<!-- Story Section -->
<section class="py-20 md:py-28 bg-white relative overflow-hidden">
    <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <!-- Text Content -->
        <div data-aos="fade-right">
            <span class="bg-orange-50 text-orange-900 px-3 py-1 rounded-full text-[10px] tracking-widest uppercase font-bold mb-4 inline-block">The Legacy</span>
            <h2 class="font-serif text-4xl md:text-5xl mb-8 leading-tight text-gray-900">
                Crafting emotions for <br> <span class="text-primary italic">decades</span>.
            </h2>
            <p class="text-gray-500 text-sm leading-7 mb-6 font-light">
                Ratannam Gold was founded on the principles of absolute purity and uncompromising craftsmanship. For nearly forty years, we have been the silent witness to thousands of stories, celebrations, and legacies.
            </p>
            <p class="text-gray-500 text-sm leading-7 mb-8 font-light">
                Based in the heart of Pali, Rajasthan, our flagship boutique is a sanctuary for those who appreciate the fine art of jewellery making. Every piece in our collection is meticulously handcrafted by master karigars whose skills have been honed over generations.
            </p>

            <div class="bg-white shadow-xl p-6 border-l-4 border-primary italic text-gray-800 text-sm font-serif max-w-md">
                "Jewelry is a piece of art that happens to be wearable."
            </div>
        </div>

        <!-- Image -->
        <div class="relative" data-aos="fade-left">
            <div class="aspect-[4/5] bg-black relative z-10 overflow-hidden shadow-2xl">
                <img src="{{ asset('images/about-profile.png') }}" class="w-full h-full object-cover">
            </div>
            <!-- Decorative Box -->
            <div class="absolute -bottom-6 -left-6 w-40 h-40 bg-gray-100 -z-0"></div>
            <div class="absolute -top-6 -right-6 w-40 h-40 border border-gray-200 -z-0"></div>
        </div>
    </div>
</section>

<!-- Stats / Features -->
<section class="py-16 bg-gray-50 border-y border-gray-100">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="group">
                <div class="w-16 h-16 rounded-full bg-white border border-gray-100 flex items-center justify-center mx-auto mb-4 group-hover:border-primary transition-colors">
                    <i class="bi bi-shop text-2xl text-primary"></i>
                </div>
                <h4 class="font-bold text-xs tracking-widest uppercase mb-1">Grand Opening</h4>
                <p class="text-[10px] text-gray-400">Visit our new flagship store.</p>
            </div>
            <div class="group">
                <div class="w-16 h-16 rounded-full bg-white border border-gray-100 flex items-center justify-center mx-auto mb-4 group-hover:border-primary transition-colors">
                    <i class="bi bi-gem text-2xl text-primary"></i>
                </div>
                <h4 class="font-bold text-xs tracking-widest uppercase mb-1">Handcrafted</h4>
                <p class="text-[10px] text-gray-400">Every piece is unique.</p>
            </div>
            <div class="group">
                <div class="w-16 h-16 rounded-full bg-white border border-gray-100 flex items-center justify-center mx-auto mb-4 group-hover:border-primary transition-colors">
                    <i class="bi bi-award text-2xl text-primary"></i>
                </div>
                <h4 class="font-bold text-xs tracking-widest uppercase mb-1">BIS Certified</h4>
                <p class="text-[10px] text-gray-400">Purity guaranteed.</p>
            </div>
            <div class="group">
                <div class="w-16 h-16 rounded-full bg-white border border-gray-100 flex items-center justify-center mx-auto mb-4 group-hover:border-primary transition-colors">
                    <i class="bi bi-heart text-2xl text-primary"></i>
                </div>
                <h4 class="font-bold text-xs tracking-widest uppercase mb-1">Customer First</h4>
                <p class="text-[10px] text-gray-400">Dedicated to your delight.</p>
            </div>
        </div>
    </div>
</section>

<!-- The Promise -->
<section class="py-24 bg-white text-center">
    <div class="container mx-auto px-6 max-w-4xl">
        <h2 class="font-serif text-4xl md:text-5xl mb-8">The Ratannam Promise</h2>
        <p class="text-gray-500 italic text-lg leading-relaxed mb-10">
            "We promise to provide not just jewelry, but a legacy of trust. Our commitment to transparent pricing (even when hidden on the web), ethical sourcing, and artistic excellence remains as pure as the gold we craft."
        </p>
        <span class="text-xs font-bold tracking-[0.3em] uppercase text-primary">The Ratannam Family</span>
    </div>
</section>

@endsection
