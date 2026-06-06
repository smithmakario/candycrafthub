@php
    $footerGridCols = auth()->guest() && Route::has('login') ? 'md:grid-cols-5' : 'md:grid-cols-4';
@endphp
<footer class="w-full py-xl px-margin-mobile md:px-margin-desktop grid grid-cols-1 {{ $footerGridCols }} gap-xl bg-surface-container-lowest border-t border-outline-variant">
    <div class="space-y-md">
        <h3 class="text-headline-sm font-headline-sm text-primary">Candy Craft Hub</h3>
        <p class="text-label-sm text-on-surface-variant">&copy; {{ date('Y') }} Candy Craft Hub. Turning ordinary moments into unforgettable ones.</p>
    </div>
    <div>
        <h4 class="font-bold mb-md text-on-surface">Explore</h4>
        <ul class="space-y-sm">
            <li><a class="text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="{{ route('shop') }}">Shop All</a></li>
            <li><a class="text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Gift Cards</a></li>
            <li><a class="text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="{{ route('event-services') }}">Event Services</a></li>
            <li><a class="text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Bulk Orders</a></li>
        </ul>
    </div>
    <div>
        <h4 class="font-bold mb-md text-on-surface">Help</h4>
        <ul class="space-y-sm">
            <li><a class="text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Lagos Delivery Zones</a></li>
            <li><a class="text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="{{ route('contact') }}">Contact Us</a></li>
            <li><a class="text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Shipping Policy</a></li>
        </ul>
    </div>
    @if (Route::has('login'))
        @guest
            <div>
                <h4 class="font-bold mb-md text-on-surface">Account</h4>
                <ul class="space-y-sm">
                    <li><a class="text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="{{ route('login') }}">Log in</a></li>
                    @if (Route::has('register'))
                        <li><a class="text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="{{ route('register') }}">Register</a></li>
                    @endif
                </ul>
            </div>
        @endguest
    @endif
    <div>
        <h4 class="font-bold mb-md text-on-surface">Legal</h4>
        <ul class="space-y-sm">
            <li><a class="text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Privacy Policy</a></li>
            <li><a class="text-label-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Terms of Service</a></li>
        </ul>
    </div>
</footer>
