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

                    @auth
                        <div class="mb-lg rounded-xl bg-primary-container/20 border border-primary/30 px-md py-sm">
                            <p class="font-label-md text-on-surface">
                                Signed in as <strong>{{ auth()->user()->name }}</strong>
                            </p>
                            <p class="font-body-sm text-on-surface-variant">{{ auth()->user()->email }}</p>
                            <p class="font-body-sm text-on-surface-variant mt-xs">
                                Track this order anytime in
                                <a href="{{ route('customer.transactions') }}" class="text-primary underline">My Transactions</a>.
                            </p>
                        </div>
                    @else
                        <fieldset class="mb-lg">
                            <legend class="block font-label-md text-label-md mb-sm">Your account</legend>
                            <p class="font-body-sm text-on-surface-variant mb-sm">
                                Create an account or sign in to track your order and payment status.
                            </p>
                            <div class="flex flex-col gap-sm mb-md">
                                <label
                                    class="account-mode-label flex items-center gap-sm px-md py-sm rounded-xl border-2 cursor-pointer transition-colors {{ old('account_mode', 'register') === 'register' ? 'border-primary bg-primary-container/20' : 'border-outline-variant hover:border-primary/50' }}">
                                    <input type="radio" name="account_mode" value="register"
                                        class="text-primary focus:ring-primary"
                                        {{ old('account_mode', 'register') === 'register' ? 'checked' : '' }}>
                                    <span class="material-symbols-outlined text-primary">person_add</span>
                                    <span>
                                        <span class="block font-label-md">Create account</span>
                                        <span class="block font-body-sm text-on-surface-variant">Quick signup while you checkout</span>
                                    </span>
                                </label>
                                <label
                                    class="account-mode-label flex items-center gap-sm px-md py-sm rounded-xl border-2 cursor-pointer transition-colors {{ old('account_mode') === 'login' ? 'border-primary bg-primary-container/20' : 'border-outline-variant hover:border-primary/50' }}">
                                    <input type="radio" name="account_mode" value="login"
                                        class="text-primary focus:ring-primary"
                                        {{ old('account_mode') === 'login' ? 'checked' : '' }}>
                                    <span class="material-symbols-outlined text-primary">login</span>
                                    <span>
                                        <span class="block font-label-md">Sign in</span>
                                        <span class="block font-body-sm text-on-surface-variant">Already have an account?</span>
                                    </span>
                                </label>
                            </div>
                            @error('account_mode')
                                <p class="mt-xs text-error font-label-sm">{{ $message }}</p>
                            @enderror

                            <div id="register-fields"
                                class="space-y-md {{ old('account_mode', 'register') === 'login' ? 'hidden' : '' }}">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                                    <div>
                                        <label for="first_name" class="block font-label-md text-label-md mb-xs">First name</label>
                                        <input id="first_name" type="text" name="first_name"
                                            value="{{ old('first_name') }}"
                                            class="w-full px-md py-sm rounded-xl bg-surface-container-lowest border-2 border-outline-variant focus:border-primary focus:ring-0">
                                        @error('first_name')
                                            <p class="mt-xs text-error font-label-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="last_name" class="block font-label-md text-label-md mb-xs">Last name</label>
                                        <input id="last_name" type="text" name="last_name"
                                            value="{{ old('last_name') }}"
                                            class="w-full px-md py-sm rounded-xl bg-surface-container-lowest border-2 border-outline-variant focus:border-primary focus:ring-0">
                                        @error('last_name')
                                            <p class="mt-xs text-error font-label-sm">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div id="phone-field">
                                    <label for="phone" class="block font-label-md text-label-md mb-xs">Phone number</label>
                                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                                        class="w-full px-md py-sm rounded-xl bg-surface-container-lowest border-2 border-outline-variant focus:border-primary focus:ring-0">
                                    @error('phone')
                                        <p class="mt-xs text-error font-label-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div id="password-confirmation-field">
                                    <label for="password_confirmation" class="block font-label-md text-label-md mb-xs">Confirm password</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation"
                                        class="w-full px-md py-sm rounded-xl bg-surface-container-lowest border-2 border-outline-variant focus:border-primary focus:ring-0">
                                    @error('password_confirmation')
                                        <p class="mt-xs text-error font-label-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>

                        <div class="mb-md">
                            <label for="email" class="block font-label-md text-label-md mb-xs">Email address</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-md py-sm rounded-xl bg-surface-container-lowest border-2 border-outline-variant focus:border-primary focus:ring-0">
                            @error('email')
                                <p class="mt-xs text-error font-label-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-lg">
                            <label for="password" class="block font-label-md text-label-md mb-xs">Password</label>
                            <input id="password" type="password" name="password" required
                                class="w-full px-md py-sm rounded-xl bg-surface-container-lowest border-2 border-outline-variant focus:border-primary focus:ring-0">
                            @error('password')
                                <p class="mt-xs text-error font-label-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    @endauth

                    <fieldset class="mb-lg">
                        <legend class="block font-label-md text-label-md mb-sm">Fulfillment</legend>
                        <div class="flex flex-col gap-sm">
                            <label
                                class="fulfillment-label flex items-center gap-sm px-md py-sm rounded-xl border-2 cursor-pointer transition-colors {{ old('fulfillment_type', 'pickup') === 'pickup' ? 'border-primary bg-primary-container/20' : 'border-outline-variant hover:border-primary/50' }}">
                                <input type="radio" name="fulfillment_type" value="pickup"
                                    class="text-primary focus:ring-primary"
                                    {{ old('fulfillment_type', 'pickup') === 'pickup' ? 'checked' : '' }}>
                                <span class="material-symbols-outlined text-primary">storefront</span>
                                <span>
                                    <span class="block font-label-md">Pickup</span>
                                    <span class="block font-body-sm text-on-surface-variant">Collect from our Lagos store</span>
                                </span>
                            </label>
                            <label
                                class="fulfillment-label flex items-center gap-sm px-md py-sm rounded-xl border-2 cursor-pointer transition-colors {{ old('fulfillment_type') === 'delivery' ? 'border-primary bg-primary-container/20' : 'border-outline-variant hover:border-primary/50' }}">
                                <input type="radio" name="fulfillment_type" value="delivery"
                                    class="text-primary focus:ring-primary"
                                    {{ old('fulfillment_type') === 'delivery' ? 'checked' : '' }}>
                                <span class="material-symbols-outlined text-primary">local_shipping</span>
                                <span>
                                    <span class="block font-label-md">Delivery</span>
                                    <span class="block font-body-sm text-on-surface-variant">We deliver to your address</span>
                                </span>
                            </label>
                        </div>
                        @error('fulfillment_type')
                            <p class="mt-xs text-error font-label-sm">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    <div id="delivery-address-fields"
                        class="mb-lg {{ old('fulfillment_type') === 'delivery' ? '' : 'hidden' }}">
                        <label for="delivery_address" class="block font-label-md text-label-md mb-xs">Delivery address</label>
                        <textarea id="delivery_address" name="delivery_address" rows="4"
                            placeholder="Street, area, city, state, and any delivery notes"
                            class="w-full px-md py-sm rounded-xl bg-surface-container-lowest border-2 border-outline-variant focus:border-primary focus:ring-0">{{ old('delivery_address') }}</textarea>
                        @error('delivery_address')
                            <p class="mt-xs text-error font-label-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <fieldset class="mb-lg">
                        <legend class="block font-label-md text-label-md mb-sm">Payment method</legend>
                        <div class="flex flex-col gap-sm">
                            @foreach ($paymentMethods as $method)
                                <label
                                    class="payment-method-label flex items-center gap-sm px-md py-sm rounded-xl border-2 cursor-pointer transition-colors {{ old('payment_method', 'paystack') === $method->value ? 'border-primary bg-primary-container/20' : 'border-outline-variant hover:border-primary/50' }}">
                                    <input type="radio" name="payment_method" value="{{ $method->value }}"
                                        class="text-primary focus:ring-primary"
                                        {{ old('payment_method', 'paystack') === $method->value ? 'checked' : '' }}>
                                    <span class="material-symbols-outlined text-primary">
                                        {{ $method === \App\PaymentMethod::Paystack ? 'credit_card' : 'account_balance' }}
                                    </span>
                                    <span>
                                        <span class="block font-label-md">{{ $method->label() }}</span>
                                        <span class="block font-body-sm text-on-surface-variant">
                                            @if ($method === \App\PaymentMethod::Paystack)
                                                Pay securely with card, bank, or USSD
                                            @else
                                                Transfer to our Providus Bank account
                                            @endif
                                        </span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('payment_method')
                            <p class="mt-xs text-error font-label-sm">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    <div id="bank-transfer-details"
                        class="mb-lg {{ old('payment_method', 'paystack') === 'bank_transfer' ? '' : 'hidden' }}">
                        @include('orders.partials.bank-transfer-details')
                    </div>

                    <p id="paystack-notice"
                        class="font-body-md text-on-surface-variant mb-lg {{ old('payment_method', 'paystack') === 'bank_transfer' ? 'hidden' : '' }}">
                        You will be redirected to Paystack to complete your payment securely.
                    </p>

                    <div class="flex justify-between font-body-lg mb-lg pt-md border-t border-outline-variant/20">
                        <span>Total</span>
                        <span class="font-bold text-primary">₦{{ number_format($subtotal, 0) }}</span>
                    </div>

                    <button type="submit" id="checkout-submit"
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
            const paymentInputs = form?.querySelectorAll('input[name="payment_method"]');
            const accountModeInputs = form?.querySelectorAll('input[name="account_mode"]');
            const registerFields = document.getElementById('register-fields');
            const passwordConfirmationField = document.getElementById('password-confirmation-field');
            const phoneField = document.getElementById('phone-field');
            const phoneInput = document.getElementById('phone');
            const firstNameInput = document.getElementById('first_name');
            const lastNameInput = document.getElementById('last_name');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const bankDetails = document.getElementById('bank-transfer-details');
            const paystackNotice = document.getElementById('paystack-notice');
            const submitButton = document.getElementById('checkout-submit');

            const toggleLabelState = (input, labelSelector) => {
                const label = input.closest(labelSelector);
                if (!label) {
                    return;
                }

                const active = input.checked;
                label.classList.toggle('border-primary', active);
                label.classList.toggle('bg-primary-container/20', active);
                label.classList.toggle('border-outline-variant', !active);
            };

            const updateAccountUi = () => {
                const selected = form?.querySelector('input[name="account_mode"]:checked');
                const isRegister = selected?.value === 'register';
                const isDelivery = form?.querySelector('input[name="fulfillment_type"]:checked')?.value === 'delivery';

                registerFields?.classList.toggle('hidden', !isRegister);
                passwordConfirmationField?.classList.toggle('hidden', !isRegister);
                phoneField?.classList.toggle('hidden', !isRegister);

                if (firstNameInput) {
                    firstNameInput.required = Boolean(isRegister);
                }

                if (lastNameInput) {
                    lastNameInput.required = Boolean(isRegister);
                }

                if (passwordConfirmationInput) {
                    passwordConfirmationInput.required = Boolean(isRegister);
                }

                if (phoneInput) {
                    phoneInput.required = Boolean(isRegister && isDelivery);
                }

                accountModeInputs?.forEach((input) => {
                    toggleLabelState(input, '.account-mode-label');
                });
            };

            const updateFulfillmentUi = () => {
                const selected = form?.querySelector('input[name="fulfillment_type"]:checked');
                const isDelivery = selected?.value === 'delivery';

                addressFields?.classList.toggle('hidden', !isDelivery);

                if (addressInput) {
                    addressInput.required = Boolean(isDelivery);
                }

                fulfillmentInputs?.forEach((input) => {
                    toggleLabelState(input, '.fulfillment-label');
                });

                updateAccountUi();
            };

            const updatePaymentUi = () => {
                const selected = form?.querySelector('input[name="payment_method"]:checked');
                const isBankTransfer = selected?.value === 'bank_transfer';

                bankDetails?.classList.toggle('hidden', !isBankTransfer);
                paystackNotice?.classList.toggle('hidden', isBankTransfer);

                if (submitButton) {
                    submitButton.textContent = isBankTransfer
                        ? 'Place order & pay by bank transfer'
                        : 'Pay with Paystack';
                }

                paymentInputs?.forEach((input) => {
                    toggleLabelState(input, '.payment-method-label');
                });
            };

            fulfillmentInputs?.forEach((input) => {
                input.addEventListener('change', updateFulfillmentUi);
            });

            paymentInputs?.forEach((input) => {
                input.addEventListener('change', updatePaymentUi);
            });

            accountModeInputs?.forEach((input) => {
                input.addEventListener('change', updateAccountUi);
            });

            updateFulfillmentUi();
            updatePaymentUi();
            updateAccountUi();
        });
    </script>
@endpush
