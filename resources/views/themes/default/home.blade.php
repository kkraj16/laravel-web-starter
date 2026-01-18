@extends('theme::layouts.app')

@section('content')

    <!-- Hero Section -->
    <!-- Hero Section -->
    <x-frontend.hero :banners="$banners" />

    <!-- Trending Masterpieces -->
    <section class="py-24 bg-gray-50">
        <div class="container mx-auto px-6">
            <x-frontend.section-title 
                title="Trending <span class='italic text-primary'>Masterpieces</span>" 
                subtitle="Timeless Trends" 
            />

            <!-- Product Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                @forelse($products as $product)
                    <x-frontend.product-card :product="$product" class="bg-white p-2" />
                @empty
                    <!-- Fallback if no products -->
                    @for ($i = 0; $i < 4; $i++)
                        <x-frontend.product-card class="bg-white p-2" />
                    @endfor
                @endforelse
            </div>

            <div class="text-center mt-16">
                 <a href="{{ route('products.index') }}" class="inline-block bg-primary text-black px-8 py-3.5 text-xs font-bold tracking-[0.2em] uppercase hover:bg-white transition-all duration-300 transform hover:-translate-y-1 shadow-[0_0_20px_rgba(200,155,60,0.3)]">
                    Shop New Arrivals
                </a>
            </div>
        </div>
    </section>

    <!-- Features / Promise Section -->
    <section class="py-24 bg-white border-t border-gray-100">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
                    <!-- BIS Hallmark -->
                    <div class="reveal-item bg-white p-10 border border-gray-100 group hover:border-primary transition-all text-center show">
                        <div class="w-14 h-14 rounded-full bg-orange-50 text-primary flex items-center justify-center mx-auto mb-6 group-hover:bg-primary group-hover:text-white transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 uppercase tracking-widest text-[11px] mb-3">BIS Hallmark</h4>
                        <p class="text-gray-500 text-xs leading-relaxed font-light">Every gram of gold is certified for its purity at our in-house labs and government centers.</p>
                    </div>

                    <!-- Bespoke Art -->
                    <div class="reveal-item bg-white p-10 border border-gray-100 group hover:border-primary transition-all text-center show">
                        <div class="w-14 h-14 rounded-full bg-orange-50 text-primary flex items-center justify-center mx-auto mb-6 group-hover:bg-primary group-hover:text-white transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-gem" aria-hidden="true"><path d="M10.5 3 8 9l4 13 4-13-2.5-6"></path><path d="M17 3a2 2 0 0 1 1.6.8l3 4a2 2 0 0 1 .013 2.382l-7.99 10.986a2 2 0 0 1-3.247 0l-7.99-10.986A2 2 0 0 1 2.4 7.8l2.998-3.997A2 2 0 0 1 7 3z"></path><path d="M2 9h20"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 uppercase tracking-widest text-[11px] mb-3">Bespoke Art</h4>
                        <p class="text-gray-500 text-xs leading-relaxed font-light">Customizations that reflect your personality. Our karigars create what you imagine.</p>
                    </div>

                    <!-- Royal Service -->
                    <div class="reveal-item bg-white p-10 border border-gray-100 group hover:border-primary transition-all text-center show">
                        <div class="w-14 h-14 rounded-full bg-orange-50 text-primary flex items-center justify-center mx-auto mb-6 group-hover:bg-primary group-hover:text-white transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star" aria-hidden="true"><path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 uppercase tracking-widest text-[11px] mb-3">Royal Service</h4>
                        <p class="text-gray-500 text-xs leading-relaxed font-light">Visit our flagship Pali boutique for a personalized, luxury shopping experience.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Voices of Elegance (Testimonials) -->
    <section class="py-24 bg-white border-t border-gray-100">
        <div class="container mx-auto px-6">
            
            <!-- Header with Controls -->
            <div class="flex flex-col md:flex-row justify-between items-end mb-12">
                <div class="text-left w-full">
                    <div class="text-primary text-[10px] tracking-[0.2em] uppercase font-bold mb-4">Testimonials</div>
                    <h2 class="font-serif text-4xl md:text-5xl text-black">Voices of Elegance</h2>
                    <div class="w-12 h-1 bg-primary mt-6"></div>
                </div>
                
                <!-- Navigation Buttons -->
                <div class="flex gap-3 mt-6 md:mt-0">
                    <button class="swiper-button-prev-custom w-12 h-12 rounded-full border border-gray-200 flex items-center justify-center hover:border-black hover:bg-black hover:text-white transition-all">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="swiper-button-next-custom w-12 h-12 rounded-full border border-gray-200 flex items-center justify-center hover:border-black hover:bg-black hover:text-white transition-all">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>

             <div class="swiper testimonial-swiper">
                <div class="swiper-wrapper py-10">
                    @forelse($testimonials as $testimonial)
                        <div class="swiper-slide h-auto flex flex-col">
                            <div class="bg-white p-10 h-full border border-gray-100 shadow-[0_5px_30px_rgba(0,0,0,0.03)] relative overflow-hidden group hover:-translate-y-2 transition-transform duration-500 flex flex-col">
                                <!-- Watermark Quote -->
                                <i class="bi bi-quote absolute -top-6 -left-4 text-8xl text-primary/10 font-serif leading-none select-none z-0"></i>
                                
                                <div class="relative z-10">
                                    <div class="flex gap-1 mb-6 text-xs text-primary">
                                       @for($i=0; $i<$testimonial->rating; $i++)
                                           <i class="bi bi-star-fill"></i>
                                       @endfor
                                    </div>
                                    
                                    <p class="font-serif text-lg italic text-gray-600 leading-relaxed mb-8 min-h-[5rem] relative z-10">
                                        "{{ $testimonial->content }}"
                                    </p>
                                    
                                    <div class="pt-6 border-t border-gray-100 mt-auto">
                                        <h5 class="text-sm font-bold uppercase tracking-[0.1em] mb-1 text-gray-900">{{ $testimonial->name }}</h5>
                                        <div class="flex items-center gap-1.5 text-[10px] font-bold text-primary uppercase tracking-widest">
                                            <i class="bi bi-patch-check-fill"></i>
                                            Verified Buyer
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Static Fallback 1 -->
                        <div class="swiper-slide h-auto flex flex-col">
                            <div class="bg-white p-10 h-full border border-gray-100 shadow-[0_5px_30px_rgba(0,0,0,0.03)] relative overflow-hidden group hover:-translate-y-2 transition-transform duration-500 flex flex-col">
                                <i class="bi bi-quote absolute -top-6 -left-4 text-8xl text-primary/10 font-serif leading-none select-none z-0"></i>
                                <div class="relative z-10 flex flex-col h-full">
                                    <div class="flex gap-1 mb-6 text-xs text-primary">
                                       <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    </div>
                                    <p class="font-serif text-lg italic text-gray-600 leading-relaxed mb-8 min-h-[5rem] relative z-10">
                                        "Beautiful designs and very transparent pricing. I loved the transparency with the live rates. Will visit again."
                                    </p>
                                    <div class="pt-6 border-t border-gray-100 mt-auto">
                                        <h5 class="text-sm font-bold uppercase tracking-[0.1em] mb-1 text-gray-900">Anjali Gupta</h5>
                                        <div class="flex items-center gap-1.5 text-[10px] font-bold text-primary uppercase tracking-widest">
                                            <i class="bi bi-patch-check-fill"></i> Verified Buyer
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Static Fallback 2 -->
                        <div class="swiper-slide h-auto flex flex-col">
                             <div class="bg-white p-10 h-full border border-gray-100 shadow-[0_5px_30px_rgba(0,0,0,0.03)] relative overflow-hidden group hover:-translate-y-2 transition-transform duration-500 flex flex-col">
                                <i class="bi bi-quote absolute -top-6 -left-4 text-8xl text-primary/10 font-serif leading-none select-none z-0"></i>
                                <div class="relative z-10 flex flex-col h-full">
                                    <div class="flex gap-1 mb-6 text-xs text-primary">
                                       <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    </div>
                                    <p class="font-serif text-lg italic text-gray-600 leading-relaxed mb-8 min-h-[5rem] relative z-10">
                                        "Excellent service and genuine quality. The staff was very helpful in helping me choose the perfect ring for my wife."
                                    </p>
                                    <div class="pt-6 border-t border-gray-100 mt-auto">
                                        <h5 class="text-sm font-bold uppercase tracking-[0.1em] mb-1 text-gray-900">Rahul Verma</h5>
                                        <div class="flex items-center gap-1.5 text-[10px] font-bold text-primary uppercase tracking-widest">
                                            <i class="bi bi-patch-check-fill"></i> Verified Buyer
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Static Fallback 3 -->
                        <div class="swiper-slide h-auto flex flex-col">
                             <div class="bg-white p-10 h-full border border-gray-100 shadow-[0_5px_30px_rgba(0,0,0,0.03)] relative overflow-hidden group hover:-translate-y-2 transition-transform duration-500 flex flex-col">
                                <i class="bi bi-quote absolute -top-6 -left-4 text-8xl text-primary/10 font-serif leading-none select-none z-0"></i>
                                <div class="relative z-10 flex flex-col h-full">
                                    <div class="flex gap-1 mb-6 text-xs text-primary">
                                       <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    </div>
                                    <p class="font-serif text-lg italic text-gray-600 leading-relaxed mb-8 min-h-[5rem] relative z-10">
                                        "Absolutely stunning craftsmanship! The gold necklace I purchased for my wedding was the highlight of my jewelry collection."
                                    </p>
                                    <div class="pt-6 border-t border-gray-100 mt-auto">
                                        <h5 class="text-sm font-bold uppercase tracking-[0.1em] mb-1 text-gray-900">Priya Sharma</h5>
                                        <div class="flex items-center gap-1.5 text-[10px] font-bold text-primary uppercase tracking-widest">
                                            <i class="bi bi-patch-check-fill"></i> Verified Buyer
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
             </div>
        </div>
    </section>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Swiper('.testimonial-swiper', {
                loop: true,
                speed: 800,
                spaceBetween: 30,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.swiper-button-next-custom',
                    prevEl: '.swiper-button-prev-custom',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 1,
                    },
                    768: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                }
            });
        });
    </script>
    @endpush

@endsection
