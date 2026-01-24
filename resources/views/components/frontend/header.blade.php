<header class="bg-white border-b border-gray-100 sticky top-0 z-50 transition-all duration-300" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 50)">
    <div class="container mx-auto px-6 h-20 flex items-center justify-between">
        
        <!-- Mobile Menu Trigger -->
        <button class="md:hidden text-2xl" @click="$dispatch('open-mobile-menu')">
            <i class="bi bi-list"></i>
        </button>

        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex flex-col items-center group">
            @if(file_exists(public_path('images/logo.png')))
                <img src="{{ asset('images/logo.png') }}" alt="Ratannam Gold" class="h-16 w-auto object-contain">
            @elseif(file_exists(public_path('images/desktop-logo.png')))
                 <img src="{{ asset('images/desktop-logo.png') }}" alt="Ratannam Gold" class="h-16 w-auto object-contain">
            @else
                <span class="font-serif text-2xl tracking-[0.2em] font-bold uppercase group-hover:text-primary transition-colors">Ratannam</span>
                <span class="text-[8px] tracking-[0.4em] text-gray-500 uppercase mt-0.5">Luxury Jewellery</span>
            @endif
        </a>

        <!-- Desktop Nav -->
        <nav class="hidden md:flex items-center space-x-10 text-xs font-medium tracking-widest uppercase">
            <a href="{{ route('products.index') }}" class="hover:text-primary transition-colors">Collections</a>
            <a href="{{ route('about') }}" class="hover:text-primary transition-colors">About Us</a>
            <a href="{{ route('contact') }}" class="hover:text-primary transition-colors">Contact</a>
        </nav>

        <!-- Mobile Right (Cart/Search - Optional) -->
        <div class="md:hidden flex items-center">
            <!-- Login button hidden -->
        </div>
    </div>
</header>

<!-- Mobile Menu Overlay -->
<div x-data="{ open: false }" 
     @open-mobile-menu.window="open = true" 
     class="md:hidden fixed inset-0 z-50 pointer-events-none">
    
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/50 transition-opacity duration-300 pointer-events-auto" 
         x-show="open" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="open = false"></div>

    <!-- Panel -->
    <div class="absolute top-0 left-0 w-3/4 h-full bg-white shadow-2xl transform transition-transform duration-300 pointer-events-auto"
         x-show="open"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full">
        
        <div class="p-6 flex justify-between items-center border-b border-gray-100">
            <span class="font-serif text-xl tracking-widest uppercase">Menu</span>
            <button @click="open = false" class="text-2xl">&times;</button>
        </div>

        <nav class="p-6 flex flex-col space-y-6 text-sm font-medium tracking-widest uppercase">
            <a href="{{ route('products.index') }}" class="block py-2 border-b border-gray-50">Collections</a>
            <a href="{{ route('about') }}" class="block py-2 border-b border-gray-50">About Us</a>
            <a href="{{ route('contact') }}" class="block py-2 border-b border-gray-50">Contact Us</a>
        </nav>
    </div>
</div>
