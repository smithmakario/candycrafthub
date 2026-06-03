@php
    $navLinkClass = fn (array $patterns): string => collect($patterns)->contains(fn (string $pattern): bool => request()->routeIs($pattern))
        ? 'flex items-center gap-md bg-primary text-on-primary rounded-xl px-md py-sm transition-all duration-200'
        : 'flex items-center gap-md text-on-surface-variant hover:bg-surface-variant rounded-xl px-md py-sm transition-all duration-200';
@endphp

<header class="md:hidden fixed top-0 left-0 right-0 z-40 bg-surface-container border-b border-outline-variant/20 px-margin-mobile py-sm flex items-center gap-sm">
    <a href="{{ route('dashboard') }}">
        <img src="{{ asset('asset/logo.png') }}" alt="Candy Craft Hub" class="h-10 w-auto object-contain">
    </a>
    <span class="text-label-md font-bold text-on-surface">Admin Portal</span>
</header>

<aside class="fixed left-0 top-0 h-full hidden md:flex flex-col p-md gap-md bg-surface-container shadow-md w-64 z-50">
    <a href="{{ route('dashboard') }}" class="mb-md px-sm shrink-0">
        <img src="{{ asset('asset/logo.png') }}" alt="Candy Craft Hub" class="h-16 w-auto object-contain">
    </a>
    <div class="mb-sm px-sm">
        <h1 class="text-label-md font-label-md font-bold text-on-surface">Admin Portal</h1>
        <p class="text-label-sm text-on-surface-variant">Management Console</p>
    </div>
    <nav class="flex flex-col gap-sm flex-1">
        <a class="{{ $navLinkClass(['dashboard']) }}" href="{{ route('dashboard') }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="text-label-md font-label-md">Dashboard</span>
        </a>
        <a class="{{ $navLinkClass(['products.*']) }}" href="{{ route('products.index') }}">
            <span class="material-symbols-outlined">shopping_bag</span>
            <span class="text-label-md font-label-md">Products</span>
        </a>
        <a class="{{ $navLinkClass(['inventory.*']) }}" href="{{ route('inventory.index') }}">
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="text-label-md font-label-md">Inventory</span>
        </a>
        <a class="{{ $navLinkClass(['bookings.*']) }}" href="{{ route('bookings.index') }}">
            <span class="material-symbols-outlined">event_available</span>
            <span class="text-label-md font-label-md">Bookings</span>
        </a>
        <a class="{{ $navLinkClass(['membership-plans.*']) }}" href="{{ route('membership-plans.index') }}">
            <span class="material-symbols-outlined">card_membership</span>
            <span class="text-label-md font-label-md">Membership Plans</span>
        </a>
    </nav>
    <div class="mt-auto border-t border-outline-variant pt-md space-y-sm">
        <div class="flex items-center gap-sm px-sm">
            <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center overflow-hidden border border-outline-variant shrink-0">
                <span class="material-symbols-outlined text-secondary">person</span>
            </div>
            <div class="min-w-0">
                <p class="text-label-md font-bold truncate">{{ Auth::user()->name }}</p>
                <p class="text-label-sm text-on-surface-variant truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-md w-full text-on-surface-variant hover:bg-surface-variant rounded-xl px-md py-sm transition-all duration-200 text-label-md font-label-md">
                <span class="material-symbols-outlined">logout</span>
                Log out
            </button>
        </form>
    </div>
</aside>
