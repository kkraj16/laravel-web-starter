@props(['product'])

<div class="relative" x-data="{ showShare: false }">
    <button @click="showShare = !showShare" class="flex items-center gap-2 text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 hover:text-gold-600 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-share-2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
        Share
    </button>
    
    <!-- Share Dropdown -->
    <div x-show="showShare" 
            @click.away="showShare = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
            style="display: none;"
            class="absolute right-0 md:right-auto md:left-1/2 md:-translate-x-1/2 top-full mt-4 w-64 bg-white shadow-[0_10px_40px_rgba(0,0,0,0.1)] rounded-sm border border-neutral-100 p-6 z-50 flex flex-col items-center gap-4 text-center">
        
        <span class="text-[10px] uppercase tracking-widest text-neutral-400 font-bold">Scan to View</span>
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('products.short', $product->id)) }}&bgcolor=ffffff" alt="QR Code" class="w-32 h-32 border border-neutral-100 p-1 rounded-sm">
        
        <div class="w-full border-t border-neutral-50"></div>
    </div>
</div>
