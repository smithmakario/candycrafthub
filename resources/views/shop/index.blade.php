@extends('layouts.marketing')

@section('title', 'Shop | Candy Craft Hub')

@section('content')
    @include('marketing.partials.nav')

    <main class="pt-xl min-h-screen">
        <section class="relative px-margin-mobile md:px-margin-desktop py-xl overflow-hidden">
            <div class="absolute top-20 right-10 candy-float opacity-20 pointer-events-none">
                <span class="material-symbols-outlined text-[120px]" data-icon="cookie">cookie</span>
            </div>
            <div class="absolute bottom-10 left-10 candy-float opacity-10 pointer-events-none" style="animation-delay: 2s;">
                <span class="material-symbols-outlined text-[80px]" data-icon="icecream">icecream</span>
            </div>
            <div class="relative z-10 max-w-4xl">
                <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-md">Crafted with Joy,
                    Delivered with Magic</h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">Discover artisanal confectionery that
                    transports you back to your sweetest memories. From nostalgic Lagos classics to global luxury treats.
                </p>
            </div>
        </section>

        @if (session('success'))
            <div class="mx-margin-mobile md:mx-margin-desktop mb-md">
                <p class="rounded-xl bg-primary-container text-on-primary-container px-md py-sm font-label-md">
                    {{ session('success') }}
                </p>
            </div>
        @endif

        <section class="px-margin-mobile md:px-margin-desktop pb-xl grid grid-cols-1 lg:grid-cols-12 gap-gutter">
            <aside class="lg:col-span-3 space-y-lg">
                <div class="glass-card p-md rounded-xl border border-outline-variant/30">
                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-md">Categories</h3>
                    <div class="flex flex-col gap-sm">
                        <a href="{{ route('shop') }}"
                            class="flex items-center justify-between group px-sm py-xs rounded-lg {{ $activeFilter === null ? 'bg-primary text-on-primary' : 'hover:bg-surface-container' }} transition-all duration-300">
                            <span class="font-label-md text-label-md">All Products</span>
                            @if ($activeFilter === null)
                                <span class="material-symbols-outlined text-sm"
                                    data-icon="arrow_forward_ios">arrow_forward_ios</span>
                            @endif
                        </a>
                        @foreach ($filters as $key => $filter)
                            <a href="{{ route('shop', ['filter' => $key]) }}"
                                class="flex items-center justify-between group px-sm py-xs rounded-lg {{ $activeFilter === $key ? 'bg-primary text-on-primary' : 'hover:bg-surface-container' }} transition-all duration-300">
                                <span class="font-label-md text-label-md">{{ $filter['label'] }}</span>
                                <span
                                    class="material-symbols-outlined text-sm {{ $activeFilter === $key ? '' : 'opacity-0 group-hover:opacity-100' }}"
                                    data-icon="arrow_forward_ios">arrow_forward_ios</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="glass-card p-md rounded-xl border border-outline-variant/30">
                    <h3 class="font-label-md text-label-md text-primary uppercase tracking-wider mb-sm">Seasonal Special
                    </h3>
                    <div class="rounded-lg overflow-hidden relative group">
                        <img alt="Special Offer"
                            class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-700"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCY93Un4OPJPhlBPL4vywRQPe_e3ryjxnSaz41KecVKYS6E8RHebqnrttqZafklttB29NEYDjV0CqL30r4H1Wj-Z9UJyGB7ggWE3Ay6i51TpaqdbbwW6Pnuw3rXJ3ib0AP06u012bNcTW1sGpG0B5Cc1y6-BG2B-9_oPgAegnWNgjp70s3csv5nbb0GHTJnPJ2rjXkof8yP5jgSh_WJ9zsCVCz8M9WAcMmg4DzgBnbr0GyafuvYBV5XT8JN1W34RJLpEy_3u8bMkRxJ" />
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent flex items-end p-md">
                            <p class="text-on-primary font-bold">Lagos Summer Mix — 20% Off</p>
                        </div>
                    </div>
                </div>
            </aside>

            <div class="lg:col-span-9">
                @if ($products->isEmpty())
                    <div class="glass-card p-xl rounded-xl text-center">
                        <p class="font-body-lg text-on-surface-variant">No products match this category yet.</p>
                        <a href="{{ route('shop') }}" class="inline-block mt-md text-primary font-label-md">View all
                            products</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-gutter">
                        @foreach ($products as $product)
                            @include('shop.partials.product-card', ['product' => $product])
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <section
            class="bg-surface-container py-xl px-margin-mobile md:px-margin-desktop text-center relative overflow-hidden">
            <div class="relative z-10 max-w-2xl mx-auto">
                <h2 class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-md">Join the Sweetest
                    Circle</h2>
                <p class="font-body-lg text-body-lg text-on-surface-variant mb-lg">Be the first to know about new flavor
                    drops and exclusive candy craft events in Lagos.</p>
                <form class="flex flex-col md:flex-row gap-md">
                    <input
                        class="flex-grow px-md py-sm rounded-full bg-surface-container-lowest border-2 border-outline-variant focus:border-primary focus:ring-0 transition-all duration-300"
                        placeholder="Enter your email" type="email" />
                    <button
                        class="bg-primary text-on-primary px-xl py-sm rounded-full font-bold hover:scale-105 transition-all"
                        type="submit">Sign Up</button>
                </form>
            </div>
        </section>
    </main>

    @include('marketing.partials.footer')
@endsection
