@extends('layouts.marketing')

@section('title', 'Checkout | Candy Craft Hub')

@section('content')
    @include('marketing.partials.nav')

    <main class="pt-xl min-h-screen px-margin-mobile md:px-margin-desktop pb-xl">
        <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-lg">Checkout</h1>

        @if (session('error'))
            <p class="mb-md rounded-xl bg-error-container text-on-error-container px-md py-sm font-label-md">
                {{ session('error') }}
            </p>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
            <div class="lg:col-span-7 space-y-md">
                @foreach ($lines as $line)
                    <div class="glass-card p-md rounded-xl flex justify-between gap-md">
                        <div>
                            <p class="font-headline-sm text-headline-sm">{{ $line['product']->name }}</p>
                            <p class="font-body-md text-on-surface-variant">Qty: {{ $line['quantity'] }}</p>
                        </div>
                        <p class="font-label-md text-primary shrink-0">
                            ₦{{ number_format($line['line_total'], 0) }}
                        </p>
                    </div>
                @endforeach
            </div>

            <aside class="lg:col-span-5">
                <form method="POST" action="{{ route('checkout.store') }}" id="checkout-form"
                    class="glass-card p-lg rounded-xl border border-outline-variant/30">
                    @csrf
                    <h2 class="font-headline-sm text-headline-sm mb-md">Order details</h2>

                    <fieldset class="mb-lg">
                        <legend class="block font-label-md text-label-md mb-sm">Fulfillment</legend>
                        <div class="flex flex-col gap-sm">
                            <label
                                class="flex items-center gap-sm px-md py-sm rounded-xl border-2 cursor-pointer transition-colors {{ old('fulfillment_type', 'pickup') === 'pickup' ? 'border-primary bg-primary-container/20' : 'border-outline-variant hover:border-primary/50' }}">
                                <input type="radio" name="fulfillment_type" value="pickup"
                                    class="text-primary focus:ring-primary"
                                    {{ old('fulfillment_type', 'pickup') === 'pickup' ? 'checked' : '' }}>
                                <span class="material-symbols-outlined text-primary"
                                    data-icon="storefront">storefront</span>
                                <span>
                                    <span class="block font-label-md">Pickup</span>
                                    <span class="block font-body-sm text-on-surface-variant">Collect from our Lagos
                                        store</span>
                                </span>
                            </label>
                            <label
                                class="flex items-center gap-sm px-md py-sm rounded-xl border-2 cursor-pointer transition-colors {{ old('fulfillment_type') === 'delivery' ? 'border-primary bg-primary-container/20' : 'border-outline-variant hover:border-primary/50' }}">
                                <input type="radio" name="fulfillment_type" value="delivery"
                                    class="text-primary focus:ring-primary"
                                    {{ old('fulfillment_type') === 'delivery' ? 'checked' : '' }}>
                                <span class="material-symbols-outlined text-primary"
                                    data-icon="local_shipping">local_shipping</span>
                                <span>
                                    <span class="block font-label-md">Delivery</span>
                                    <span class="block font-body-sm text-on-surface-variant">We deliver to your
                                        address</span>
                                </span>
                            </label>
                        </div>
                        @error('fulfillment_type')
                            <p class="mt-xs text-error font-label-sm">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    <div id="delivery-address-fields"
                        class="mb-lg {{ old('fulfillment_type') === 'delivery' ? '' : 'hidden' }}">
                        <label for="delivery_address" class="block font-label-md text-label-md mb-xs">Delivery
                            address</label>
                        <textarea id="delivery_address" name="delivery_address" rows="4"
                            placeholder="Street, area, city, state, and any delivery notes"
                            class="w-full px-md py-sm rounded-xl bg-surface-container-lowest border-2 border-outline-variant focus:border-primary focus:ring-0">{{ old('delivery_address') }}</textarea>
                        @error('delivery_address')
                            <p class="mt-xs text-error font-label-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-md">
                        <label for="email" class="block font-label-md text-label-md mb-xs">Email address</label>
                        <input id="email" type="email" name="email" value="{{ old('email', auth()->user()?->email) }}"
                            required
                            class="w-full px-md py-sm rounded-xl bg-surface-container-lowest border-2 border-outline-variant focus:border-primary focus:ring-0">
                        @error('email')
                            <p class="mt-xs text-error font-label-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <p class="font-body-md text-on-surface-variant mb-lg">
                        You will be redirected to Paystack to complete your payment securely.
                    </p>

                    <div class="flex justify-between font-body-lg mb-lg pt-md border-t border-outline-variant/20">
                        <span>Total</span>
                        <span class="font-bold text-primary">₦{{ number_format($subtotal, 0) }}</span>
                    </div>

                    <button type="submit"
                        class="w-full bg-primary text-on-primary px-lg py-sm rounded-full font-label-md hover:scale-105 transition-all">
                        Pay with Paystack
                    </button>
                </form>
            </aside>
        </div>
    </main>

    @include('marketing.partials.footer')
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('checkout-form');
            const addressFields = document.getElementById('delivery-address-fields');
            const addressInput = document.getElementById('delivery_address');
            const fulfillmentInputs = form?.querySelectorAll('input[name="fulfillment_type"]');

            const updateFulfillmentUi = () => {
                const selected = form?.querySelector('input[name="fulfillment_type"]:checked');
                const isDelivery = selected?.value === 'delivery';

                addressFields?.classList.toggle('hidden', !isDelivery);
                if (addressInput) {
                    addressInput.required = Boolean(isDelivery);
                }

                fulfillmentInputs?.forEach((input) => {
                    const label = input.closest('label');
                    if (!label) {
                        return;
                    }

                    const active = input.checked;
                    label.classList.toggle('border-primary', active);
                    label.classList.toggle('bg-primary-container/20', active);
                    label.classList.toggle('border-outline-variant', !active);
                });
            };

            fulfillmentInputs?.forEach((input) => {
                input.addEventListener('change', updateFulfillmentUi);
            });

            updateFulfillmentUi();
        });
    </script>
@endpush
