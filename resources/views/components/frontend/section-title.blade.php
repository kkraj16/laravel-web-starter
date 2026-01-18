@props(['title', 'subtitle' => ''])

<div {{ $attributes->merge(['class' => 'text-center mb-16 px-4']) }} data-aos="fade-up">
    @if($subtitle)
        <div class="text-primary text-[10px] tracking-[0.2em] uppercase font-bold mb-3 flex items-center justify-center gap-3">
             <span class="w-8 h-px bg-primary/30"></span>
             {{ $subtitle }}
             <span class="w-8 h-px bg-primary/30"></span>
        </div>
    @endif
    <h2 class="font-serif text-3xl md:text-4xl lg:text-5xl text-gray-900 leading-tight">
        {!! $title !!}
    </h2>
    <div class="w-16 h-0.5 bg-primary mx-auto mt-6"></div>
</div>
