@if($products->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @foreach($products as $product)
            <div class="group relative">
                <div class="aspect-[4/5] bg-gray-100 overflow-hidden relative mb-4">
                    @if($product->gallery && count($product->gallery) > 0)
                        <img 
                            src="{{ asset('storage/' . $product->gallery[0]) }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        >
                        @if(isset($product->gallery[1]))
                            <img 
                                src="{{ asset('storage/' . $product->gallery[1]) }}" 
                                alt="{{ $product->name }}" 
                                class="absolute inset-0 w-full h-full object-cover opacity-0 group-hover:opacity-100 transition-opacity duration-700"
                            >
                        @endif
                    @elseif($product->thumbnail)
                        <img 
                            src="{{ asset('storage/' . $product->thumbnail) }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        >
                    @elseif($product->primary_image)
                        <img 
                            src="{{ $product->primary_image }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        >
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-50 text-gray-300">
                            <i class="bi bi-card-image text-4xl"></i>
                        </div>
                    @endif

                    @if($product->is_new)
                        <span class="absolute top-2 left-2 bg-black text-white text-[10px] uppercase font-bold tracking-widest px-2 py-1">New</span>
                    @endif

                    @if(!$product->in_stock)
                        <div class="absolute inset-0 bg-white/60 flex items-center justify-center">
                            <span class="bg-white px-3 py-1 text-xs uppercase tracking-widest font-bold border border-black">Out of Stock</span>
                        </div>
                    @endif

                    <div class="absolute bottom-4 left-0 right-0 px-4 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-4 group-hover:translate-y-0 text-center">
                        <a href="{{ route('products.show', $product->slug) }}" class="inline-block w-full bg-white text-black text-xs font-bold uppercase tracking-widest py-3 hover:bg-black hover:text-white transition-colors shadow-lg">
                            View Details
                        </a>
                    </div>
                </div>

                <div class="text-center">
                    <h3 class="font-serif text-lg mb-1 group-hover:text-primary transition-colors">
                        <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                    </h3>
                    <div class="flex flex-wrap justify-center gap-2 text-xs text-gray-500 uppercase tracking-wider mb-2">
                        @if($product->purity)
                            <span>{{ $product->purity }}</span>
                        @endif
                        @if($product->material)
                            <span>{{ $product->material }}</span>
                        @endif
                    </div>
                    @if(!$product->hide_price)
                        <p class="font-medium">
                            ₹{{ number_format($product->price, 0) }}
                        </p>
                    @else
                        <p class="font-medium text-primary uppercase text-xs tracking-widest">Price on Request</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-12 flex justify-center">
        {{ $products->links() }}
    </div>
@else
    <div class="flex flex-col items-center justify-center py-20 bg-gray-50 text-center px-4">
        <i class="bi bi-search text-4xl text-gray-300 mb-4"></i>
        <h3 class="font-serif text-2xl mb-2">No masterpieces found</h3>
        <p class="text-gray-500 font-light max-w-md mx-auto mb-6">We couldn't find any products matching your specific requirements. Try adjusting your filters.</p>
        <button @click="clearFilters()" class="text-xs font-bold uppercase tracking-widest border-b border-black pb-1 hover:text-primary hover:border-primary transition-colors">
            Clear all filters
        </button>
    </div>
@endif
