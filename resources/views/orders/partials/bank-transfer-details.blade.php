@props(['reference' => null, 'order' => null])

@php
    $canSubmit = $order
        && $order->isBankTransfer()
        && $order->status === \App\OrderStatus::Pending
        && ! $order->hasSubmittedPayment();
    $awaitingApproval = $order
        && $order->isPendingApproval();
@endphp

<div {{ $attributes->merge(['class' => 'rounded-xl border border-outline-variant/30 bg-surface-container-low p-md space-y-md']) }}>
    <div>
        <h3 class="font-headline-sm text-headline-sm mb-xs">Bank transfer details</h3>
        <p class="font-body-sm text-on-surface-variant">
            Transfer the order total to one of the accounts below. Use your order reference as the payment description.
        </p>
    </div>

    <dl class="space-y-xs font-body-md">
        <div class="flex justify-between gap-md">
            <dt class="text-on-surface-variant">Account name</dt>
            <dd class="font-label-md">{{ config('bank.name') }}</dd>
        </div>
        <div class="flex justify-between gap-md">
            <dt class="text-on-surface-variant">Bank</dt>
            <dd class="font-label-md">{{ config('bank.bank') }}</dd>
        </div>
        @if ($reference)
            <div class="flex justify-between gap-md">
                <dt class="text-on-surface-variant">Payment reference</dt>
                <dd class="font-mono text-sm">{{ $reference }}</dd>
            </div>
        @endif
    </dl>

    @if ($canSubmit)
        <form method="POST" action="{{ route('orders.submit-payment', $order) }}" id="bank-transfer-form" class="space-y-md">
            @csrf

            <fieldset>
                <legend class="block font-label-md text-label-md mb-sm">Which account did you pay into?</legend>
                <div class="space-y-sm">
                    @foreach (config('bank.accounts') as $account)
                        <label
                            class="bank-account-label flex items-start gap-sm px-md py-sm rounded-xl border-2 cursor-pointer transition-colors {{ old('bank_account_currency') === $account['currency'] ? 'border-primary bg-primary-container/20' : 'border-outline-variant hover:border-primary/50' }}">
                            <input type="radio" name="bank_account_currency" value="{{ $account['currency'] }}"
                                class="mt-1 text-primary focus:ring-primary"
                                {{ old('bank_account_currency') === $account['currency'] ? 'checked' : '' }}
                                required>
                            <span class="min-w-0">
                                <span class="block font-label-md">{{ $account['label'] }}</span>
                                <span class="block font-mono font-label-md">{{ $account['number'] }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>
                @error('bank_account_currency')
                    <p class="mt-xs text-error font-label-sm">{{ $message }}</p>
                @enderror
            </fieldset>

            <button type="submit"
                class="w-full bg-primary text-on-primary px-lg py-sm rounded-full font-label-md hover:scale-105 transition-all">
                I made payment to the above account
            </button>
        </form>
    @else
        <div class="space-y-sm">
            @foreach (config('bank.accounts') as $account)
                <div @class([
                    'rounded-lg px-md py-sm border',
                    'bg-primary-container/20 border-primary' => $awaitingApproval && $order->bank_account_currency === $account['currency'],
                    'bg-surface-container-lowest border-outline-variant/20' => ! $awaitingApproval || $order->bank_account_currency !== $account['currency'],
                ])>
                    <p class="font-label-sm text-on-surface-variant">{{ $account['label'] }}</p>
                    <p class="font-mono font-label-md">{{ $account['number'] }}</p>
                </div>
            @endforeach
        </div>
    @endif

    @if ($awaitingApproval)
        <p class="rounded-xl bg-primary-container/30 text-on-surface px-md py-sm font-body-sm">
            Payment submitted on {{ $order->payment_submitted_at->format('M j, Y g:i A') }}
            to <strong>{{ $order->paidToBankAccountLabel() }}</strong>.
            We are verifying your transfer and will email you once confirmed.
        </p>
    @else
        <p class="font-body-sm text-on-surface-variant">
            We will confirm your order once we receive your transfer. This usually takes 2–4 hours.
        </p>
    @endif
</div>

@if ($canSubmit)
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const form = document.getElementById('bank-transfer-form');
                const accountInputs = form?.querySelectorAll('input[name="bank_account_currency"]');

                const updateAccountUi = () => {
                    accountInputs?.forEach((input) => {
                        const label = input.closest('.bank-account-label');
                        if (!label) {
                            return;
                        }

                        const active = input.checked;
                        label.classList.toggle('border-primary', active);
                        label.classList.toggle('bg-primary-container/20', active);
                        label.classList.toggle('border-outline-variant', !active);
                    });
                };

                accountInputs?.forEach((input) => {
                    input.addEventListener('change', updateAccountUi);
                });

                updateAccountUi();
            });
        </script>
    @endpush
@endif
