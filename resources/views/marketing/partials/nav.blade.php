@php
    $navLinkClass = fn (string $routeName): string => request()->routeIs($routeName)
        ? 'text-primary transition-colors duration-300 font-label-md text-label-md'
        : 'text-on-surface-variant hover:text-primary transition-colors duration-300 font-label-md text-label-md';
@endphp
<nav class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-margin-mobile md:px-margin-desktop py-md max-w-full bg-surface/40 backdrop-blur-md shadow-sm">
    <a href="{{ route('home') }}" class="flex items-center shrink-0">
        <img src="{{ asset('asset/logo.png') }}" alt="Candy Craft Hub" class="h-20 w-auto object-contain">
    </a>
    <div class="hidden md:flex gap-lg items-center">
        <a href="{{ route('home') }}" class="{{ $navLinkClass('home') }}">Home</a>
        <a href="{{ route('shop') }}" class="{{ $navLinkClass('shop') }}">Shop</a>
        <a href="{{ route('event-services') }}" class="{{ $navLinkClass('event-services') }}">Event Services</a>
        <a href="{{ route('our-story') }}" class="{{ $navLinkClass('our-story') }}">Our Story</a>
    </div>
    <div class="flex items-center gap-md">
        @if (Route::has('login'))
            @auth
                <a
                    href="{{ route(auth()->user()->homeRoute()) }}"
                    class="text-on-surface-variant hover:text-primary transition-colors duration-300 text-label-md font-label-md hidden md:block"
                >
                    {{ auth()->user()->isAdmin() ? 'Dashboard' : 'My Account' }}
                </a>
            @endauth
        @endif
        <a href="{{ route('cart.index') }}" class="relative material-symbols-outlined text-primary hover:scale-110 transition-transform p-sm" aria-label="Shopping cart">
            shopping_cart
            @if (($cartItemCount ?? 0) > 0)
                <span class="absolute -top-1 -right-1 min-w-[1.25rem] h-5 px-1 rounded-full bg-secondary text-on-secondary text-[10px] font-bold flex items-center justify-center">
                    {{ $cartItemCount }}
                </span>
            @endif
        </a>
        <button type="button" id="mobile-menu-toggle" class="md:hidden material-symbols-outlined text-primary" aria-label="Open menu">menu</button>
    </div>
</nav>
