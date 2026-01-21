@props(['banners' => []])

<div class="relative w-full h-[600px] md:h-[800px] bg-black overflow-hidden" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 500)">
    
    <!-- Skeleton Loader -->
    <div x-show="!loaded" class="absolute inset-0 bg-gray-900 animate-pulse flex items-center justify-center">
        <div class="text-center w-full max-w-2xl px-6">
            <div class="h-4 bg-gray-800 rounded w-24 mx-auto mb-6"></div>
            <div class="h-12 bg-gray-800 rounded w-3/4 mx-auto mb-8"></div>
            <div class="h-px bg-gray-800 w-16 mx-auto mb-8"></div>
            <div class="h-10 bg-gray-800 rounded w-32 mx-auto"></div>
        </div>
    </div>

    <!-- Swiper Slider -->
    <div x-show="loaded" 
         x-transition:enter="transition ease-out duration-1000"
         x-transition:enter-start="opacity-0 transform scale-105"
         x-transition:enter-end="opacity-100 transform scale-100"
         class="swiper hero-swiper h-full w-full">
        <div class="swiper-wrapper">
            @forelse($banners as $banner)
                <div class="swiper-slide relative flex items-center justify-center overflow-hidden">
                    <!-- Background Image -->
                    <!-- Desktop Background Image -->
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-[10000ms] ease-linear transform {{ $banner->animate_image ? 'scale-100 hover:scale-110' : '' }} hidden md:block" 
                         style="background-image: url('{{ $banner->image_path }}'); {{ $banner->animate_image ? 'animation: zoomEffect 20s infinite alternate;' : '' }}">
                    </div>

                    <!-- Mobile Background Image -->
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-[10000ms] ease-linear transform {{ $banner->animate_image ? 'scale-100 hover:scale-110' : '' }} md:hidden" 
                         style="background-image: url('{{ $banner->mobile_image_path ?: $banner->image_path }}'); {{ $banner->animate_image ? 'animation: zoomEffect 20s infinite alternate;' : '' }}">
                    </div>

                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black pointer-events-none" style="opacity: {{ $banner->overlay_opacity }};"></div>
                    
                    <!-- Content -->
                    <!-- Content -->
                    @php
                        $alignmentClass = match($banner->text_alignment ?? 'center') {
                            'left' => 'text-left items-start mr-auto ml-4 md:ml-12 max-w-xl',
                            'right' => 'text-right items-end ml-auto mr-4 md:mr-12 max-w-xl',
                            default => 'text-center items-center mx-auto max-w-5xl',
                        };
                    @endphp

                    <div class="relative z-10 text-white px-4 mt-20 flex flex-col justify-center h-full pb-20 {{ $alignmentClass }} w-full md:w-auto" data-aos="fade-up">
                        
                        <!-- Dynamic Content Image -->
                        @if($banner->show_content_image && $banner->content_image_path)
                            @php
                                $imgAlign = match($banner->content_position ?? 'center') {
                                    'left' => 'self-start',
                                    'right' => 'self-end',
                                    default => 'self-center',
                                };
                            @endphp
                            <img src="{{ $banner->content_image_path }}" class="w-36 md:w-36 mb-6 object-contain drop-shadow-xl {{ $imgAlign }}" alt="Banner Content">
                        @endif

                        @if($banner->show_content)
                            @if($banner->title)
                                <h1 class="font-serif text-5xl md:text-7xl lg:text-8xl mb-6 leading-tight">
                                    {!! $banner->title !!}
                                </h1>
                            @endif
                            
                            @if($banner->subtitle)
                                <p class="text-gray-300 mb-10 text-sm md:text-base tracking-wide max-w-xl leading-relaxed">
                                {!! $banner->subtitle !!}
                                </p>
                            @endif

                            @if($banner->button_text && $banner->button_link)
                                <a href="{{ $banner->button_link }}" class="inline-block bg-primary text-black px-8 py-3.5 text-xs font-bold tracking-[0.2em] uppercase hover:bg-white transition-all duration-300 transform hover:-translate-y-1 shadow-[0_0_20px_rgba(200,155,60,0.3)]">
                                    {{ $banner->button_text }}
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            @empty
                <!-- Static Slide 1 (Fallback) -->
                <div class="swiper-slide relative flex items-center justify-center">
                    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/banner/banner-background.jpg') }}');">
                        <div class="absolute inset-0 bg-black/60"></div>
                    </div>
                    <div class="relative z-10 text-center text-white px-4 max-w-4xl mx-auto mt-20" data-aos="fade-up">
                      
                         <img src="{{ asset('images/banner/logo-text.png') }}" class="w-48 sm:w-56 md:w-72 lg:w-96 xl:w-[450px] mb-6 mx-auto object-contain drop-shadow-xl" alt="Banner Content">
                        <!-- <h1 class="font-serif text-5xl md:text-7xl lg:text-8xl mb-6 leading-tight">
                            Tradition <span class="text-primary italic">Redefined</span>
                        </h1> -->
                        <!-- <p class="text-gray-300 mb-10 text-sm md:text-base tracking-wide max-w-xl mx-auto leading-relaxed">
                            Discover a legacy of craftsmanship and purity.
                        </p> -->
                        <div class="flex flex-col items-center gap-6 mb-4">
                            <p class="inline-block py-1 px-3 border border-primary/50 text-action-gold tracking-[0.2em] text-[10px] uppercase rounded-full backdrop-blur-sm">
                                Discover a legacy of craftsmanship and purity.
                            </p>
                            <a href="{{ route('products.index') }}" class="inline-block bg-primary text-black px-8 py-3.5 text-xs font-bold tracking-[0.2em] uppercase hover:bg-white transition-all duration-300 transform hover:-translate-y-1 shadow-[0_0_20px_rgba(200,155,60,0.3)]">
                                Explore Collection
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        
        <div class="swiper-pagination !bottom-10"></div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Swiper('.hero-swiper', {
            loop: true,
            effect: 'fade',
            speed: 1000,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                renderBullet: function (index, className) {
                    return '<span class="' + className + ' !bg-white !opacity-50 hover:!opacity-100 !w-2 !h-2 !mx-2 transition-opacity"></span>';
                },
            },
        });
    });
</script>

<style>
@keyframes zoomEffect {
    0% { transform: scale(1); }
    100% { transform: scale(1.15); }
}
</style>
@endpush
