@extends('layouts.marketing')

@section('title', 'Cart | Candy Craft Hub')

@section('content')
    @include('marketing.partials.nav')

    <main class="pt-xl min-h-screen px-margin-mobile md:px-margin-desktop pb-xl">
        <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-lg">Your Cart</h1>

        @if (session('success'))
            <p class="mb-md rounded-xl bg-primary-container text-on-primary-container px-md py-sm font-label-md">
                {{ session('success') }}
            </p>
        @endif

        @if (session('error'))
            <p class="mb-md rounded-xl bg-error-container text-on-error-container px-md py-sm font-label-md">
                {{ session('error') }}
            </p>
        @endif

        @if ($lines->isEmpty())
            <div class="glass-card p-xl rounded-xl text-center">
                <p class="font-body-lg text-on-surface-variant mb-md">Your cart is empty.</p>
                <a href="{{ route('shop') }}"
                    class="inline-flex bg-primary text-on-primary px-lg py-sm rounded-full font-label-md hover:scale-105 transition-all">
                    Continue Shopping
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
                <div class="lg:col-span-8 space-y-md">
                    @foreach ($lines as $line)
                        @php
                            $product = $line['product'];
                        @endphp
                        <div
                            class="glass-card p-md rounded-xl border border-outline-variant/20 flex flex-col sm:flex-row gap-md items-start sm:items-center">
                            @if ($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                    class="w-24 h-24 rounded-lg object-cover shrink-0">
                            @endif
                            <div class="flex-grow min-w-0">
                                <h2 class="font-headline-sm text-headline-sm text-on-surface">{{ $product->name }}</h2>
                                <p class="font-body-md text-on-surface-variant">{{ $product->formattedPrice() }} each</p>
                                <p class="font-label-md text-primary mt-xs">
                                    Line total: ₦{{ number_format($line['line_total'], 0) }}
                                </p>
                            </div>
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-sm shrink-0">
                                <form method="POST" action="{{ route('cart.update', $product) }}"
                                    class="flex items-center gap-sm">
                                    @csrf
                                    @method('PATCH')
                                    <label for="quantity-{{ $product->id }}"
                                        class="sr-only">Quantity</label>
                                    <input id="quantity-{{ $product->id }}" type="number" name="quantity" min="0"
                                        max="99" value="{{ $line['quantity'] }}"
                                        class="w-20 rounded-lg border border-outline-variant px-sm py-xs text-center"
                                        onchange="this.form.submit()">
                                </form>
                                <form method="POST" action="{{ route('cart.destroy', $product) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-error font-label-md hover:underline">Remove</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <aside class="lg:col-span-4">
                    <div class="glass-card p-lg rounded-xl border border-outline-variant/30 sticky top-28">
                        <h2 class="font-headline-sm text-headline-sm mb-md">Order Summary</h2>
                        <div class="flex justify-between font-body-lg mb-lg">
                            <span>Subtotal</span>
                            <span class="font-bold text-primary">₦{{ number_format($subtotal, 0) }}</span>
                        </div>
                        <a href="{{ route('checkout.create') }}"
                            class="block w-full text-center bg-primary text-on-primary px-lg py-sm rounded-full font-label-md hover:scale-105 transition-all">
                            Proceed to Checkout
                        </a>
                        <a href="{{ route('shop') }}"
                            class="block w-full text-center mt-md text-on-surface-variant font-label-md hover:text-primary">
                            Continue Shopping
                        </a>
                    </div>
                </aside>
            </div>
        @endif
    </main>

    @include('marketing.partials.footer')
@endsection
