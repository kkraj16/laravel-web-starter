@extends('theme::layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="relative py-20 bg-black flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 opacity-40 bg-cover bg-center" style="background-image: url('{{ asset('images/banner/banner-background.jpg') }}');"></div>
        <div class="relative z-10 text-center text-white px-4">
            <span class="text-xs font-bold tracking-[0.3em] uppercase text-primary mb-3 block">Exquisite Selection</span>
            <h1 class="font-serif text-4xl md:text-5xl mb-4">The Collection</h1>
            <div class="w-12 h-0.5 bg-primary mx-auto mb-1"></div>
            <p class="text-gray-300 max-w-lg mx-auto text-sm leading-relaxed font-light">
                Explore our curated vault of fine gold and silver jewellery. Each piece is a testament to our heritage of purity and craftsmanship.
            </p>
        </div>
    </div>

<!-- Two Column Layout: Filter Sidebar + Product Grid -->
<section class="bg-gray-50 py-20" x-data="productFilter">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left Sidebar - Filters -->
            <aside class="lg:col-span-3">
                <div class="bg-white shadow-lg rounded-lg p-6 sticky top-24">
                    <div class="space-y-6">
                        <!-- Search Filter -->
                        <div>
                            <h4 class="font-serif text-lg mb-4 text-gray-900">Search</h4>
                            <input 
                                type="text" 
                                x-model="filters.search"
                                @input.debounce.500ms="updateFilters()"
                                placeholder="Search products..." 
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors text-sm"
                            >
                        </div>

                        <!-- Categories Filter -->
                        <div>
                            <h4 class="font-serif text-lg mb-4 text-gray-900">Categories</h4>
                            <div class="space-y-2">
                                @foreach($categories as $category)
                                    <button
                                        @click="if(filters.categories.includes({{ $category->id }})) { filters.categories = filters.categories.filter(id => id !== {{ $category->id }}) } else { filters.categories.push({{ $category->id }}) }; updateFilters()"
                                        :class="filters.categories.includes({{ $category->id }}) ? 'bg-primary text-white font-bold' : 'bg-gray-50 text-gray-700 hover:bg-primary hover:text-white'"
                                        class="w-full text-left px-4 py-2 text-sm rounded transition-colors"
                                    >
                                        {{ $category->name }}
                                        @if($category->products_count > 0)
                                            <span class="text-xs opacity-70">({{ $category->products_count }})</span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Range Filter -->
                        <div>
                            <h4 class="font-serif text-lg mb-4 text-gray-900">Price Range</h4>
                            <div class="flex gap-2">
                                <input 
                                    type="number" 
                                    x-model="filters.min_price"
                                    @input.debounce.500ms="updateFilters()"
                                    placeholder="Min" 
                                    min="{{ $minPrice }}"
                                    max="{{ $maxPrice }}"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors text-sm"
                                >
                                <input 
                                    type="number" 
                                    x-model="filters.max_price"
                                    @input.debounce.500ms="updateFilters()"
                                    placeholder="Max" 
                                    min="{{ $minPrice }}"
                                    max="{{ $maxPrice }}"
                                    class="w-1/2 px-3 py-2 border border-gray-300 rounded focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors text-sm"
                                >
                            </div>
                        </div>

                        <!-- Material Filter -->
                        <div>
                            <h4 class="font-serif text-lg mb-4 text-gray-900">Material</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($materials as $material)
                                    <button
                                        @click="if(filters.materials.includes('{{ $material->value }}')) { filters.materials = filters.materials.filter(m => m !== '{{ $material->value }}') } else { filters.materials.push('{{ $material->value }}') }; updateFilters()"
                                        :class="filters.materials.includes('{{ $material->value }}') ? 'bg-primary text-white border-primary' : 'bg-white border-gray-300 text-gray-700 hover:border-primary hover:text-primary'"
                                        class="px-4 py-2 border rounded text-xs uppercase tracking-wider transition-colors"
                                    >
                                        {{ $material->value }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Purity Filter  -->
                        <div>
                            <h4 class="font-serif text-lg mb-4 text-gray-900">Purity</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($purities as $purity)
                                    <button
                                        @click="if(filters.purities.includes('{{ $purity->value }}')) { filters.purities = filters.purities.filter(p => p !== '{{ $purity->value }}') } else { filters.purities.push('{{ $purity->value }}') }; updateFilters()"
                                        :class="filters.purities.includes('{{ $purity->value }}') ? 'bg-primary text-white border-primary' : 'bg-white border-gray-300 text-gray-700 hover:border-primary hover:text-primary'"
                                        class="px-4 py-2 border rounded text-xs uppercase tracking-wider transition-colors"
                                    >
                                        {{ $purity->value }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Clear All Filters -->
                        <div>
                            <button 
                                @click="clearFilters()" 
                                class="w-full bg-black text-white py-3 rounded text-xs uppercase tracking-widest font-bold hover:bg-gray-800 transition-colors"
                            >
                                Clear all filters
                            </button>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Right Content - Product Grid -->
            <main class="lg:col-span-9">
                <!-- Loading Indicator -->
                <div x-show="loading" class="flex justify-center items-center py-20">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
                </div>

                <!-- Product Grid Container -->
                <div id="product-grid-container" x-show="!loading">
                    @include('themes.default.products.partials.product-list')
                </div>
            </main>

        </div>
    </div>
</section>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('productFilter', () => ({
                loading: false,
                filters: {
                    search: new URLSearchParams(window.location.search).get('search') || '',
                    categories: new URLSearchParams(window.location.search).getAll('categories[]').map(Number),
                    materials: new URLSearchParams(window.location.search).getAll('materials[]'),
                    purities: new URLSearchParams(window.location.search).getAll('purities[]'),
                    min_price: new URLSearchParams(window.location.search).get('min_price') || '',
                    max_price: new URLSearchParams(window.location.search).get('max_price') || '',
                    sort: new URLSearchParams(window.location.search).get('sort') || 'newest',
                },
                totalProducts: '{{ $products->total() }}',

                init() {
                    // Update total count on load if needed
                },

                async updateFilters() {
                    this.loading = true;
                    
                    // Build Query String
                    const params = new URLSearchParams();
                    if(this.filters.search) params.append('search', this.filters.search);
                    this.filters.categories.forEach(id => params.append('categories[]', id));
                    this.filters.materials.forEach(m => params.append('materials[]', m));
                    this.filters.purities.forEach(p => params.append('purities[]', p));
                    if(this.filters.min_price) params.append('min_price', this.filters.min_price);
                    if(this.filters.max_price) params.append('max_price', this.filters.max_price);
                    params.append('sort', this.filters.sort);

                    // Update URL without reload
                    const newUrl = `${window.location.pathname}?${params.toString()}`;
                    window.history.pushState({}, '', newUrl);

                    try {
                        const response = await fetch(newUrl, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        const html = await response.text();
                        
                        // Parse HTML to extract product grid
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newGrid = doc.querySelector('#product-grid-container').innerHTML;
                        
                        document.querySelector('#product-grid-container').innerHTML = newGrid;
                        
                        // Update total count if possible (extract from new HTML or pass as data attribute)
                        // This is a simple scrape, might need refinement if count is dynamic
                        // For now assuming the controller returns the whole view, we can grab the count from a data attribute if we added one, 
                        // or just rely on the server side render.
                        // Ideally we should return a JSON with html and count, but instructed to keep minimal changes.
                        
                    } catch (error) {
                        console.error('Error fetching products:', error);
                    } finally {
                        this.loading = false;
                    }
                },

                clearFilters() {
                    this.filters = {
                        search: '',
                        categories: [],
                        materials: [],
                        purities: [],
                        min_price: '',
                        max_price: '',
                        sort: 'newest'
                    };
                    this.updateFilters();
                },
                
                resetCategory() {
                    this.filters.categories = [];
                    this.updateFilters();
                }
            }));
        });
    </script>
    @endpush
@endsection
