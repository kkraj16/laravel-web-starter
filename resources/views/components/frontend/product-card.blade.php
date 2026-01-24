@props(['product' => null, 'class' => ''])

@php
    $image = $product && $product->primary_image ? $product->primary_image : asset('images/no-image.png');
    $name = $product ? $product->name : 'Royal Koon Kundan Set';
    $category = ($product && $product->categories->isNotEmpty()) ? $product->categories->first()->name : 'Necklaces';
    $price = $product ? '₹ ' . number_format($product->price, 2) : '₹ 1,450.00';
    $isNew = $product ? $product->created_at->diffInDays(now()) < 30 : true;
    // For demo/fallback, link to #
    $link = '#'; 
@endphp

<div class="group relative bg-white h-full flex flex-col {{ $class }}" x-data="{ loaded: false }">
    
    <!-- Image Skeleton -->
    <div x-show="false" class="aspect-[4/5] bg-gray-100 animate-pulse w-full relative overflow-hidden flex-shrink-0">
         <div class="absolute inset-0 bg-gradient-to-r from-gray-100 via-gray-50 to-gray-100 shimmer"></div>
    </div>

    <!-- Product Image -->
    <div class="aspect-[4/5] relative overflow-hidden bg-gray-50 flex-shrink-0">
        <a href="{{ $link }}" class="block w-full h-full">
            <img src="{{ $image }}" 
                 alt="{{ $name }}" 
                 loading="lazy"
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                 @load="loaded = true"
                 x-on:error="$el.src = '{{ asset('images/no-image.png') }}'; loaded = true"
                 :class="{ 'opacity-0': !loaded, 'opacity-100': loaded }"
            >
            <!-- Secondary Hover Image (Optional) -->
            <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </a>

        <!-- Badges -->
        <div class="absolute top-3 left-3 flex flex-col space-y-2 pointer-events-none">
            @if($product && $product->stock_status == 'outofstock')
            <span class="bg-red-500 text-white text-[10px] tracking-wider uppercase font-bold px-2 py-1 shadow-sm">
                Out of Stock
            </span>
            @elseif($isNew)
            <span class="bg-white/90 text-[10px] tracking-wider uppercase font-bold px-2 py-1 shadow-sm">
                New
            </span>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="absolute bottom-4 left-0 right-0 px-4 translate-y-full opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
            @if($product && $product->stock_status == 'outofstock')
                <button 
                    class="w-full bg-gray-300 text-gray-500 text-xs font-bold uppercase py-3 shadow-lg cursor-not-allowed flex items-center justify-center gap-2"
                    disabled
                >
                    <i class="bi bi-x-circle"></i> Currently Unavailable
                </button>
            @else
                <div class="grid grid-cols-2 gap-2">
                    <a 
                        href="{{ $product ? route('products.show', $product->slug) : '#' }}"
                        class="bg-black text-white text-xs font-bold uppercase py-3 shadow-lg hover:bg-primary hover:text-black transition-colors flex items-center justify-center gap-2"
                    >
                        <i class="bi bi-eye"></i> Details
                    </a>
                    <button 
                        class="bg-white text-black text-xs font-bold uppercase py-3 shadow-lg hover:bg-black hover:text-white transition-colors flex items-center justify-center gap-2"
                        data-product-inquiry
                        data-product-name="{{ $name }}"
                        data-product-sku="{{ $product?->sku ?? 'N/A' }}"
                        data-product-price="{{ $price }}"
                        data-product-url="{{ $link }}"
                        data-whatsapp-number="{{ \App\Models\Setting::get('contact_whatsapp') ?? '919928154903' }}"
                    >
                        <i class="bi bi-whatsapp text-green-500"></i> Inquire
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Details -->
    <div class="py-4 text-center flex-grow flex flex-col justify-between">
        <div>
            <a href="{{ $link }}" class="block mb-1">
                <h3 class="font-serif text-lg text-gray-900 group-hover:text-primary transition-colors line-clamp-1 px-2">
                    {{ $name }}
                </h3>
            </a>
            <p class="text-xs text-gray-400 uppercase tracking-widest">{{ $category }}</p>
        </div>
        
        @php
            $hidePrices = \App\Models\Setting::get('hide_prices', 0);
        @endphp
        
        <div class="flex items-center justify-center gap-2 text-sm font-medium mt-3">
            @if($hidePrices)
                <span class="text-primary uppercase text-xs font-bold tracking-widest">Price on Request</span>
            @else
                @if($product && $product->sale_price && $product->sale_price < $product->price)
                    <span class="text-gray-400 line-through text-xs">₹{{ number_format($product->price) }}</span>
                    <span class="text-red-600 font-bold">₹{{ number_format($product->sale_price) }}</span>
                @else
                    <span class="text-black">{{ $price }}</span>
                @endif
            @endif
        </div>
    </div>
</div>
