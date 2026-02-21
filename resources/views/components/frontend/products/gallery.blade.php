@props(['product'])

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
