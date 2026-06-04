@php
    $heroImage = 'https://images.unsplash.com/photo-1519741497674-611481863552';
    $heroImageParams = 'auto=format&fit=crop&q=90';
@endphp

<section class="relative w-full h-[614px] md:h-[716px] flex items-center overflow-hidden px-margin-mobile md:px-margin-desktop">
    <div class="absolute inset-0 z-0">
        <img
            alt="A luxurious high-end outdoor wedding reception at sunset with long tables, floral arrangements, and warm ambient lighting."
            class="w-full h-full object-cover object-center"
            src="{{ $heroImage }}?{{ $heroImageParams }}&w=2560"
            srcset="{{ $heroImage }}?{{ $heroImageParams }}&w=1280 1280w, {{ $heroImage }}?{{ $heroImageParams }}&w=1920 1920w, {{ $heroImage }}?{{ $heroImageParams }}&w=2560 2560w"
            sizes="100vw"
            fetchpriority="high"
            decoding="async"
        >
        <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/35 to-black/15" aria-hidden="true"></div>
    </div>
    <div class="relative z-10 max-w-2xl text-white">
        <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg mb-md leading-tight">Sweetening Every Lagos Celebration</h1>
        <p class="font-body-lg text-body-lg mb-lg text-white/90">From opulent weddings to corporate milestones, we craft bespoke candy experiences that taste as exquisite as they look.</p>
        <a class="inline-block bg-[#ffb7ce] text-[#864d61] px-xl py-md rounded-full font-bold hover:scale-105 transition-transform duration-300 shadow-lg" href="#intake-form">Start Planning</a>
    </div>
    <div class="absolute top-20 right-[15%] candy-float hidden lg:block opacity-40">
        <span class="material-symbols-outlined text-[80px] text-primary-container">icecream</span>
    </div>
    <div class="absolute bottom-20 right-[5%] candy-float hidden lg:block opacity-30" style="animation-delay: 2s">
        <span class="material-symbols-outlined text-[100px] text-secondary-container">cake</span>
    </div>
</section>
