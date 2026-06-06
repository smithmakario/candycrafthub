@extends('layouts.marketing')

@section('title', 'Order #' . $order->id . ' | Candy Craft Hub')

@section('content')
    @include('marketing.partials.nav')

    <main class="pt-xl min-h-screen px-margin-mobile md:px-margin-desktop pb-xl max-w-3xl mx-auto">
        <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-md">
            {{ $order->isPaid() ? 'Order Receipt' : 'Order Confirmation' }}
        </h1>

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

        @if ($order->isPaid())
            @include('orders.partials.receipt', ['order' => $order])
        @elseif (auth()->check() && auth()->user()->isCustomer())
            <p class="mb-md rounded-xl bg-surface-container px-md py-sm font-body-sm text-on-surface-variant">
                Track this order in
                <a href="{{ route('customer.transactions') }}" class="text-primary underline">My Transactions</a>.
            </p>
        @endif

        <div class="glass-card p-lg rounded-xl border border-outline-variant/30 mb-lg">
            <dl class="space-y-sm font-body-md">
                <div class="flex justify-between gap-md">
                    <dt class="text-on-surface-variant">Order reference</dt>
                    <dd class="font-mono text-sm">{{ $order->reference }}</dd>
                </div>
                <div class="flex justify-between gap-md">
                    <dt class="text-on-surface-variant">Status</dt>
                    <dd class="font-label-md {{ $order->isPaid() ? 'text-primary' : 'text-on-surface' }}">
                        {{ $order->statusLabel() }}
                    </dd>
                </div>
                <div class="flex justify-between gap-md">
                    <dt class="text-on-surface-variant">Payment method</dt>
                    <dd>{{ $order->payment_method->label() }}</dd>
                </div>
                <div class="flex justify-between gap-md">
                    <dt class="text-on-surface-variant">Email</dt>
                    <dd>{{ $order->email }}</dd>
                </div>
                <div class="flex justify-between gap-md">
                    <dt class="text-on-surface-variant">Fulfillment</dt>
                    <dd>{{ $order->fulfillment_type->label() }}</dd>
                </div>
                @if ($order->fulfillment_type === \App\FulfillmentType::Delivery && $order->delivery_address)
                    <div class="flex flex-col gap-xs">
                        <dt class="text-on-surface-variant">Delivery address</dt>
                        <dd class="whitespace-pre-line">{{ $order->delivery_address }}</dd>
                    </div>
                @endif
                <div class="flex justify-between gap-md">
                    <dt class="text-on-surface-variant">Total</dt>
                    <dd class="font-headline-sm text-primary">₦{{ number_format($order->total_amount, 0) }}</dd>
                </div>
                @if ($order->paid_at)
                    <div class="flex justify-between gap-md">
                        <dt class="text-on-surface-variant">Paid at</dt>
                        <dd>{{ $order->paid_at->format('M j, Y g:i A') }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        @if ($order->isBankTransfer() && $order->status === \App\OrderStatus::Pending)
            <div class="mb-lg">
                @include('orders.partials.bank-transfer-details', [
                    'reference' => $order->reference,
                    'order' => $order,
                ])
            </div>
        @endif

        <h2 class="font-headline-sm text-headline-sm mb-md">Items</h2>
        <ul class="space-y-sm mb-lg">
            @foreach ($order->items as $item)
                <li class="glass-card p-md rounded-xl flex justify-between gap-md">
                    <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                    <span class="text-primary font-label-md">₦{{ number_format($item->line_total, 0) }}</span>
                </li>
            @endforeach
        </ul>

        @if ($order->status === \App\OrderStatus::Pending && ! $order->isBankTransfer())
            <a href="{{ route('payment.initiate', $order) }}"
                class="inline-flex bg-primary text-on-primary px-lg py-sm rounded-full font-label-md hover:scale-105 transition-all">
                Retry Payment
            </a>
        @endif

        <a href="{{ route('shop') }}"
            class="inline-flex ml-md text-on-surface-variant font-label-md hover:text-primary">
            Back to Shop
        </a>
    </main>

    @include('marketing.partials.footer')
@endsection
