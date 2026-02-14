@extends('theme::layouts.app')

@section('content')
<div class="bg-white min-h-screen py-12 lg:py-20">
    <div class="mx-auto px-6 max-w-7xl">
        
        <!-- Minimalist Header: Breadcrumbs & Category -->
        <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-neutral-100 pb-6">
            <!-- Breadcrumbs -->
            <nav class="flex items-center text-[10px] md:text-xs uppercase tracking-[0.2em] text-neutral-400 font-medium">
                <a href="{{ route('home') }}" class="hover:text-gold-600 transition-colors">Home</a>
                <span class="mx-3 text-neutral-300">/</span>
                <a href="{{ route('products.index') }}" class="hover:text-gold-600 transition-colors">Shop</a>
                @if($product->categories->first())
                    <span class="mx-3 text-neutral-300">/</span>
                    <a href="{{ route('products.index', ['category' => $product->categories->first()->slug]) }}" class="text-neutral-900 hover:text-gold-600 transition-colors">
                        {{ $product->categories->first()->name }}
                    </a>
                @endif
            </nav>

            <!-- Optional: Share/Wishlist Actions could go here -->
        </div>

        <!-- Product Layout with Gallery -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24" x-data="{ activeImage: '{{ $product->primary_image }}' }">
            
            <!-- Left: Product Gallery -->
            <div class="space-y-4 lg:sticky lg:top-24 h-fit">
                <!-- Main Image -->
                <div class="aspect-[4/5] bg-neutral-50 overflow-hidden relative group rounded-sm w-full">
                    <img :src="activeImage" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-50"
                         x-transition:enter-end="opacity-100">
                    
                    @if($product->stock_status == 'outofstock')
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur text-neutral-900 px-4 py-2 text-[10px] font-bold uppercase tracking-[0.2em]">
                            Sold Out
                        </div>
                    @endif
                </div>

                <!-- Thumbnails (Horizontal Scroll) -->
                @if($product->images->count() > 1)
                    <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide snap-x">
                        @foreach($product->images as $image)
                            <button @click="activeImage = '{{ asset('storage/' . $image->image_path) }}'" 
                                    class="flex-shrink-0 w-20 h-20 border border-transparent hover:border-gold-600 transition-all duration-200 overflow-hidden rounded-sm focus:outline-none focus:border-gold-600 relative group snap-start"
                                    :class="{ 'border-gold-600 ring-1 ring-gold-600': activeImage === '{{ asset('storage/' . $image->image_path) }}' }">
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     alt="Thumbnail" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-200"></div>
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right: Product Details (Editorial Style) -->
            <div class="flex flex-col pt-2">
                <!-- Category Eyebrow -->
                <div class="mb-4 text-xs font-bold uppercase tracking-[0.2em] text-gold-600">
                    {{ $product->categories->first()?->name ?? 'Fine Jewelry' }}
                </div>
                
                <!-- Title -->
                <h1 class="font-serif text-4xl md:text-5xl text-neutral-900 mb-8 leading-tight">
                    {{ $product->name }}
                </h1>
                
                <!-- Price -->
                <div class="flex items-center gap-4 mb-10 pb-8 border-b border-neutral-100">
                    @php
                        $hidePrices = \App\Models\Setting::get('hide_prices', 0);
                    @endphp

                    @if($hidePrices)
                         <span class="text-xl font-medium text-neutral-900">Price on Request</span>
                    @else
                        @if($product->price > 0 && ($product->stock_status == 'instock' || $product->manage_stock == false))
                            @if($product->sale_price)
                                <span class="text-xl text-neutral-400 line-through font-light">₹{{ number_format($product->price) }}</span>
                                <span class="text-3xl font-medium text-neutral-900">₹{{ number_format($product->sale_price) }}</span>
                            @else
                                <span class="text-3xl font-medium text-neutral-900">₹{{ number_format($product->price) }}</span>
                            @endif
                        @else
                             <span class="text-xl font-medium text-neutral-900">Price on Request</span>
                        @endif
                    @endif
                </div>

                <!-- Description -->
                <div class="prose prose-neutral text-base text-neutral-600 mb-12 max-w-none leading-relaxed font-light">
                    {!! nl2br(e($product->description)) !!}
                </div>

                <!-- Attributes List (Clean) -->
                <div class="mb-12">
                    <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-neutral-900 mb-6">Product Details</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-neutral-100 last:border-0">
                            <span class="text-sm text-neutral-500 font-light">Material</span>
                            <span class="text-sm font-medium text-neutral-900">{{ $product->material?->value ?? 'N/A' }}</span>
                        </div>
                        <!-- <div class="flex justify-between items-center py-3 border-b border-neutral-100 last:border-0">
                            <span class="text-sm text-neutral-500 font-light">Purity</span>
                            <span class="text-sm font-medium text-neutral-900">{{ $product->purity?->value ?? 'N/A' }}</span>
                        </div> -->
                        @if($product->weight)
                        <div class="flex justify-between items-center py-3 border-b border-neutral-100 last:border-0">
                            <span class="text-sm text-neutral-500 font-light">Gross Weight</span>
                            <span class="text-sm font-medium text-neutral-900">{{ $product->weight }} g</span>
                        </div>
                        @endif
                         <div class="flex justify-between items-center py-3 border-b border-neutral-100 last:border-0">
                            <span class="text-sm text-neutral-500 font-light">SKU</span>
                            <span class="text-sm font-medium text-neutral-900 font-mono text-xs">{{ $product->sku ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-auto">
                     @if($product->stock_status == 'outofstock')
                        <button disabled class="w-full py-5 text-center bg-neutral-100 text-neutral-400 text-xs font-bold uppercase tracking-[0.2em] cursor-not-allowed">
                            Currently Unavailable
                        </button>
                     @else
                        <button 
                            class="w-full py-5 bg-[#25D366] text-white text-xs font-bold uppercase tracking-[0.2em] hover:bg-[#128C7E] transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1 flex items-center justify-center gap-3 group rounded-sm"
                            data-product-inquiry
                            data-product-name="{{ $product->name }}"
                            data-product-sku="{{ $product->sku ?? 'N/A' }}"
                            data-product-price="₹{{ number_format($product->price) }}"
                            data-product-url="{{ url()->current() }}"
                            data-whatsapp-number="{{ \App\Models\Setting::get('contact_whatsapp') ?? '919928154903' }}"
                        >
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" class="group-hover:scale-110 transition-transform"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"></path></svg>
                            Inquire via WhatsApp
                        </button>
                        <p class="text-center mt-4 text-[10px] text-neutral-400 font-medium">Expert assistance available via WhatsApp</p>
                     @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
