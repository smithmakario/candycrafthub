@extends('layouts.marketing')

@section('title', 'Our Story | Candy Craft Hub')

@section('content')
    @include('marketing.partials.nav')

    <main class="pt-[88px]">
    <!-- Section 1: Hero Header -->
    <header class="relative overflow-hidden min-h-[819px] flex flex-col md:flex-row">
        <!-- Left Side: Retro Jar -->
        <div class="w-full md:w-1/2 h-[409px] md:h-auto relative">
            <img class="w-full h-full object-cover"
                data-alt="A vintage, ornate glass candy jar filled with colorful retro sweets, set against a soft, nostalgic warm-toned background with gentle sun rays. The lighting is ethereal and premium, emphasizing the textures of the sugar-coated treats and the intricate glass patterns. A sense of timeless joy and whimsical luxury is conveyed through a soft-focus lens and a palette of muted pinks and golds."
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBa0A7j0gSzonAiIGl6Li4cBygEgLRstBviZrwjkT4p4izIF0th9OOxqtWrY9mqkko2emvST2Ccm-RRwzw0tAgX25Hja0XURPVyQ0WjICmw8DzIdzuIKdYr07DjrBxgMadOEAYtBCepVRjRoLXbueawAi3lbBQDX9q8C3592koBzKXY_QpEMZBqBbz8dV9pHzZoX7PJML9t9XZdL948RBLIsbi4XqS4FWqsQQj7SOx0KzoYymTVtDahzoG9709JiaCdmyN2qmn6qr2Q" />
            <div class="absolute inset-0 bg-primary/10"></div>
        </div>
        <!-- Right Side: Modern Lagos Setup -->
        <div class="w-full md:w-1/2 h-[409px] md:h-auto relative">
            <img class="w-full h-full object-cover"
                data-alt="A modern, high-end event setup in a vibrant Lagos lounge, featuring a sleek, minimalist candy bar with geometric glass tiers. The scene is illuminated by trendy neon accents and soft ambient lighting, showcasing a sophisticated dessert table at a luxury wedding or corporate gala. The atmosphere is energetic and celebratory, with a color palette of deep magenta, gold, and crisp white."
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBL-M4GCe4e-0hGbybn7pJuYkF-ydxLmYyM0FlNi9rEyAyLBhfRPtS9Q8U4ryGJArpuQssTOUTnE-JcnLomAf8bu3R66VevCl7tdi1QKgdCgetiaB2no9hbvY4qIJuMbAXuTs3o5PM-AbLj8Q1CfhoRp5FkzkqvaOwcoLLaWIR9gdwSKoEm52Gtt0mUjrwsQnTr1zAG4UHJAlRX0L2ZZZAcilk0COC5Bz59iuCjdkcNIWXx1dSsBuCcfccp81PeG_cp_hJFgNfgvWWz" />
            <div class="absolute inset-0 bg-secondary/10"></div>
        </div>
        <!-- Center Overlay Content -->
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none p-margin-mobile">
            <div class="glass-card p-lg rounded-xl max-w-2xl text-center pointer-events-auto shadow-premium">
                <h1
                    class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface mb-md">
                    Where <span class="text-primary italic">Nostalgia</span> Meets Discovery
                </h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant mb-lg">
                    Because candy is more than just a treat—it’s an experience, a memory, and a story waiting to be
                    shared.
                </p>
                <a class="inline-block bg-primary text-on-primary font-label-md text-label-md px-lg py-md rounded-full hover:scale-105 transition-transform duration-300"
                    href="#journey">
                    Read Our Journey
                </a>
            </div>
        </div>
    </header>
    <!-- Section 2: The Core Philosophy -->
    <section
        class="py-xl px-margin-mobile md:px-margin-desktop bg-surface flex flex-col md:flex-row gap-xl items-center"
        id="journey">
        <div class="w-full md:w-1/2 space-y-md">
            <h2 class="font-headline-md text-headline-md text-primary">Sweet Memories</h2>
            <div class="w-16 h-1 bg-tertiary rounded-full"></div>
            <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
                Candy Craft Hub was born from a simple idea, candy is more than just a treat it’s an experience.
                We believe that every candy holds a memory, from the sweet you saved your allowance for as a child, to the chocolate shared with a friend after school, to the colorful gummies passed around at celebrations. Candy has a way of bringing people together, sparking laughter, and turning ordinary moments into unforgettable ones.

            </p>
            <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
                At Candy Craft Hub, we are passionate about introducing you to the incredible world of candy from nostalgic classics to exciting new flavors from around the globe bringing to your reach varieties of candy to help you discover new favorites.
                We are not just selling sweets, we are curating experiences, sharing memories and creating new stories.

            </p>
        </div>
        <div class="w-full md:w-1/2 grid grid-cols-2 gap-md relative">
            <!-- Floating candy elements (Visual Flourish) -->
            <div class="absolute -top-10 -right-10 candy-float opacity-20 hidden md:block">
                <span class="material-symbols-outlined text-[80px] text-primary">icecream</span>
            </div>
            <img class="rounded-xl shadow-premium aspect-square object-cover"
                data-alt="A warm-toned collage of childhood candy moments, featuring children laughing and sharing vibrant sweets on a sunny Lagos porch. The lighting is golden and nostalgic, reminiscent of a summer afternoon. The visual style is candid and heartwarming, using soft focus and a palette of warm browns, oranges, and pastel pinks to evoke a sense of heritage and joy."
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDj9-27_0NWhxb2pFM7e2IQBOTVlcGwbXanyCH2NWk4tC_WoJlGWdhxBJDOP58RSEEa8zL4QiJ9ye4qNo4IgdMs0JKXn8Iy6YwODIwm_rZhn1MBP2czerirmYKDNyT2RAqoA6RP62N8BSubh-LE51vCGNimpRmGwhZP3H7Y1XwilcqDP9Fh-eM_ju33l7xl97ZjguldHPEpzQMbLW_HZC-YlAasvVTc_h1PwBpkzLkvl14VNlHySassedGMXxbT2UWZhEidVDwhSoRZ" />
            <img class="rounded-xl shadow-premium aspect-square object-cover translate-y-md"
                data-alt="Macro photography of glistening, sugar-coated gummy bears in a variety of jewel tones like ruby red and amber yellow. The lighting is soft and directional, highlighting the translucent quality of the candies. The aesthetic is high-end and appetizing, fitting for a premium confectionery brand focusing on craftsmanship and quality textures."
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAXhRFrLmDV-VCjkqqFz9B_506VkEkPt0ll7RvSGK-Y7ukdzLDlrKp1Kc6yBc7JVluSjgHkml_P8TZrjdpXrY5wFCtEHqt9FPxxPR1-BUxnoIamuANZ_gvFVeSqhNRyu2ndVDy9Me4uiTcpttzmjxwj4LjFNtwi5amSVMkTQVMzy9bzXc7PuNiiInrb0CfHy6kYMgWDC_9D8eYRu6HB4KVw1s17DpUGQLA3a5xSllAFi_bruK1PBRyTHePdj9Uvw3AM9FU5ElbUPrlr" />
        </div>
    </section>
    <!-- Section 3: Our Mission -->
    <section
        class="py-xl px-margin-mobile md:px-margin-desktop bg-surface-container flex flex-col-reverse md:flex-row gap-xl items-center">
        <div class="w-full md:w-1/2">
            <div class="relative group">
                <div
                    class="absolute -inset-4 bg-secondary-container/30 rounded-xl blur-xl group-hover:blur-2xl transition-all duration-500">
                </div>
                <img class="relative rounded-xl shadow-premium w-full aspect-video object-cover transition-transform duration-500 group-hover:scale-[1.02]"
                    data-alt="A curated display of premium global candies from different cultures, including Japanese matcha chocolates, Belgian truffles, and Mexican spiced tamarind treats. The arrangement is artistic and colorful, set on a minimalist white stone surface. The lighting is bright and clean, emphasizing a modern 'Flavor Explorer' theme with high-key photography and vibrant, natural saturation."
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuB4mWyCT4hqZ96blbKsnQzpvhFDj4P3qOIrrgIMm7nd0Il8NkuRk7j4shC5TRnRLuh-9r_Ocxnq9wl-JON8rKxPdWRTPMmA0GZekJNc_hW9tHeD3MF_nlajuqIDpO38GSPwUTwg0TZHzr3Y1Q6ABFjQHbGENcLGJohGda7fsBD6ymq9LnxLTJnuB0wE6gbCmMTuZIRNs7d97Rnd7BLSH761CrO43bRpaot0hyWyS_6scnKWr1zDFxoi7nmlrIYiK-UmP5T_5D0zYrUt" />
            </div>
        </div>
        <div class="w-full md:w-1/2 space-y-md">
            <span
                class="inline-block px-md py-xs bg-secondary-container text-on-secondary-container rounded-full font-label-sm text-label-sm">Our
                Global Quest</span>
            <h2 class="font-headline-md text-headline-md text-secondary">The Flavor Explorers</h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
                In a vibrant city as Lagos we bring color, joy, sweetness to birthdays, weddings, corporate events, hangouts and everyday indulgences. Whether it’s a carefully crafted candy box, a themed candy setup or simply the thrill of trying something new we make every interaction delightful.
Candy Craft Hub is where nostalgia meets discovery, childhood memories blend with new adventures and every bite tells a story because life is sweeter when it’s shared.
            </p>
            <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
                Our mission is to expand the Nigerian palate, introducing sophisticated textures and global flavor
                profiles—from the intense citrus of Japanese yuzu drops to the rich complexity of single-origin dark
                chocolates. We bring the world's finest craftsmanship to your doorstep.
            </p>
        </div>
    </section>
    <!-- Section 4: Lagos Celebrations & Impact -->
    <section class="relative min-h-[614px] flex items-center overflow-hidden">
        <img class="absolute inset-0 w-full h-full object-cover"
            data-alt="A lively, high-energy wedding reception in Lagos, Nigeria, with people dancing and celebrating around a grand, artisanal candy table. The lighting is festive with golden fairy lights and vibrant party hues. The scene captures the spirit of Lagos luxury and community, with well-dressed guests enjoying colorful confectioneries in a sophisticated, joyful environment."
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDd5m-XNR-hLtLXN_DaLXNnk2CuFtoBNzplaNa43IdKZPZP8A6pvy0GcT_jPegn9NLPZi3J908t8f-iVhXMQivy7byA3okjFWHJqaGi533ZIcgkRMVVOYjtlwU1H_V5rI-3DMUSa7CrSVYyENzY-QWXO0mVDDbZ18N5BNROVq4yDN69ZRJCFm6LoFqaNA6HdaJe_hCG9z2zsJzI69wnxe70gT13OnOrLoVf2MAWyqe-1G2o2KO0nHwjMKsErAV7te0Ps-d3JqtgrLLz" />
        <div class="absolute inset-0 bg-gradient-to-r from-on-surface/80 to-transparent"></div>
        <div class="relative px-margin-mobile md:px-margin-desktop max-w-3xl space-y-md text-surface">
            <h2 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg">Bringing
                Sweetness to the Heart of Lagos</h2>
            <p class="font-body-lg text-body-lg text-surface-container-low max-w-xl">
                Lagos is a city of movement, rhythm, and grand celebrations. We are proud to be the pulse of its most
                vibrant moments. From intimate birthdays in Lekki to corporate launches in Victoria Island, we curate
                candy experiences that mirror the city's infectious energy and premium culture.
            </p>
            <div class="flex flex-wrap gap-md pt-md">
                <div class="flex items-center gap-base px-md py-sm glass-card rounded-lg">
                    <span class="material-symbols-outlined text-tertiary-fixed">celebration</span>
                    <span class="font-label-md text-label-md">500+ Events</span>
                </div>
                <div class="flex items-center gap-base px-md py-sm glass-card rounded-lg">
                    <span class="material-symbols-outlined text-primary-container">favorite</span>
                    <span class="font-label-md text-label-md">10k+ Smiles</span>
                </div>
            </div>
        </div>
    </section>
    <!-- Interactive Component: Our Core Ingredients -->
    <section class="py-xl px-margin-mobile md:px-margin-desktop bg-surface">
        <div class="text-center mb-lg space-y-sm">
            <h2 class="font-headline-md text-headline-md text-primary">Our Core Ingredients</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">The pillars that define every box we craft.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
            <!-- Card 1 -->
            <div
                class="group p-lg rounded-xl glass-card text-center transition-all duration-300 hover:-translate-y-2 cursor-pointer border-t-4 border-primary">
                <div
                    class="w-16 h-16 bg-primary-fixed rounded-full flex items-center justify-center mx-auto mb-md group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-primary text-3xl">history_edu</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm text-on-surface mb-sm">Nostalgia</h3>
                <p class="font-body-md text-body-md text-on-surface-variant">The memories we cherish, preserved in every
                    bite of our classic heritage collection.</p>
            </div>
            <!-- Card 2 -->
            <div
                class="group p-lg rounded-xl glass-card text-center transition-all duration-300 hover:-translate-y-2 cursor-pointer border-t-4 border-secondary">
                <div
                    class="w-16 h-16 bg-secondary-fixed rounded-full flex items-center justify-center mx-auto mb-md group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-secondary text-3xl">explore</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm text-on-surface mb-sm">Discovery</h3>
                <p class="font-body-md text-body-md text-on-surface-variant">The global flavors we explore, bringing
                    international craftsmanship to your doorstep.</p>
            </div>
            <!-- Card 3 -->
            <div
                class="group p-lg rounded-xl glass-card text-center transition-all duration-300 hover:-translate-y-2 cursor-pointer border-t-4 border-tertiary">
                <div
                    class="w-16 h-16 bg-tertiary-fixed rounded-full flex items-center justify-center mx-auto mb-md group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-tertiary text-3xl">diversity_3</span>
                </div>
                <h3 class="font-headline-sm text-headline-sm text-on-surface mb-sm">Connection</h3>
                <p class="font-body-md text-body-md text-on-surface-variant">The Lagos communities we bring together,
                    turning ordinary events into unforgettable stories.</p>
            </div>
        </div>
    </section>
    <!-- Footer CTA Banner -->
    <section class="py-xl px-margin-mobile md:px-margin-desktop">
        <div class="bg-surface-container-high rounded-xl p-lg md:p-xl text-center space-y-lg relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10 pointer-events-none"
                style="background-image: radial-gradient(#864d61 2px, transparent 2px); background-size: 32px 32px;">
            </div>
            <div class="relative z-10 space-y-md">
                <h2
                    class="font-display-lg-mobile md:font-headline-md text-display-lg-mobile md:text-headline-md text-on-surface max-w-2xl mx-auto">
                    Life is sweeter when it’s shared. Ready to craft your next memory?
                </h2>
            </div>
            <div class="relative z-10 flex flex-col md:flex-row justify-center items-center gap-md">
                <button
                    class="w-full md:w-auto bg-tertiary text-on-tertiary font-label-md text-label-md px-lg py-md rounded-full shadow-premium hover:scale-105 transition-transform active:opacity-80">
                    Shop Our Candy Boxes
                </button>
                <button
                    class="w-full md:w-auto border-2 border-secondary text-secondary font-label-md text-label-md px-lg py-md rounded-full hover:bg-secondary hover:text-white transition-all active:opacity-80">
                    Book an Event Setup
                </button>
            </div>
        </div>
    </section>
    </main>

    @include('marketing.partials.footer')
@endsection
