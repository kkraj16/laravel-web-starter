<footer class="bg-black text-white pt-20 pb-10 border-t-4 border-primary/80">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            
            <!-- Brand Column -->
            <div class="md:col-span-1">
                <h3 class="text-accent text-lg font-serif mb-6">{{ $siteName }} | Luxury Jewellery & Heritage</h3>
                <p class="text-gray-400 text-sm leading-relaxed mb-6">
                    {{ $siteTagline }}
                </p>
                <div class="flex space-x-4">
                    @if($contactInfo['facebook'] && $contactInfo['facebook'] !== '#')
                        <a href="{{ $contactInfo['facebook'] }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition-colors" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    @endif
                    @if($contactInfo['instagram'] && $contactInfo['instagram'] !== '#')
                        <a href="{{ $contactInfo['instagram'] }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition-colors" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    @endif
                    @if($contactInfo['twitter'] && $contactInfo['twitter'] !== '#')
                        <a href="{{ $contactInfo['twitter'] }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition-colors" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                    @endif
                </div>
            </div>

            <!-- Links 1 -->
            <div>
                <h4 class="text-xs font-bold tracking-[0.2em] uppercase mb-6 text-gray-200">Explore</h4>
                <ul class="space-y-4 text-sm text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-primary transition-colors">Our Collection</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-primary transition-colors">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-primary transition-colors">Contact</a></li>
                </ul>
            </div>

            <!-- Links 2 - Dynamic Collections -->
            <div>
                <h4 class="text-xs font-bold tracking-[0.2em] uppercase mb-6 text-gray-200">Collections</h4>
                <ul class="space-y-4 text-sm text-gray-400">
                    @forelse($footerCategories as $category)
                        <li>
                            <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="hover:text-primary transition-colors">
                                {{ $category->name }}
                            </a>
                        </li>
                    @empty
                        <li><a href="{{ route('products.index') }}" class="hover:text-primary transition-colors">All Products</a></li>
                    @endforelse
                </ul>
            </div>

            <!-- Contact - Dynamic Contact Information -->
            <div>
                <h4 class="text-xs font-bold tracking-[0.2em] uppercase mb-6 text-gray-200">Visit Us</h4>
                <ul class="space-y-6 text-sm text-gray-400">
                    @if($contactInfo['address'])
                        <li class="flex items-start">
                            <i class="bi bi-geo-alt text-primary mt-1 mr-3"></i>
                            <span>{!! nl2br(e($contactInfo['address'])) !!}</span>
                        </li>
                    @endif
                    @if($contactInfo['phone'])
                        <li class="flex items-center">
                            <i class="bi bi-telephone text-primary mr-3"></i>
                            <a href="tel:{{ str_replace([' ', '-', '(', ')'], '', $contactInfo['phone']) }}" class="hover:text-primary transition-colors">
                                {{ $contactInfo['phone'] }}
                            </a>
                        </li>
                    @endif
                    @if($contactInfo['email'])
                        <li class="flex items-center">
                            <i class="bi bi-envelope text-primary mr-3"></i>
                            <a href="mailto:{{ $contactInfo['email'] }}" class="hover:text-primary transition-colors">
                                {{ $contactInfo['email'] }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-600">
            <p>&copy; {{ date('Y') }} {{ $siteName }} | Luxury Jewellery & Heritage. All rights reserved.</p>
            <p class="mt-2 md:mt-0 tracking-widest uppercase">Designed for Luxury</p>
        </div>
    </div>
</footer>
