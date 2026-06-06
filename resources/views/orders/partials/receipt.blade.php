<div class="glass-card p-lg rounded-xl border border-secondary/30 mb-lg">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-sm mb-md">
        <div>
            <h2 class="font-headline-sm text-headline-sm text-secondary">Payment receipt</h2>
            <p class="font-body-sm text-on-surface-variant">Your payment has been confirmed.</p>
        </div>
        <span class="inline-flex px-sm py-1 rounded-full text-label-sm bg-secondary-container text-on-secondary-container shrink-0">
            Paid
        </span>
    </div>

    <dl class="space-y-sm font-body-md">
        <div class="flex justify-between gap-md">
            <dt class="text-on-surface-variant">Order reference</dt>
            <dd class="font-mono text-sm">{{ $order->reference }}</dd>
        </div>
        <div class="flex justify-between gap-md">
            <dt class="text-on-surface-variant">Paid at</dt>
            <dd>{{ $order->paid_at?->format('M j, Y g:i A') }}</dd>
        </div>
        <div class="flex justify-between gap-md">
            <dt class="text-on-surface-variant">Payment method</dt>
            <dd>{{ $order->payment_method->label() }}</dd>
        </div>
        @if ($order->paidToBankAccountLabel())
            <div class="flex justify-between gap-md">
                <dt class="text-on-surface-variant">Paid to</dt>
                <dd>{{ $order->paidToBankAccountLabel() }}</dd>
            </div>
        @endif
        <div class="flex justify-between gap-md">
            <dt class="text-on-surface-variant">Email</dt>
            <dd>{{ $order->email }}</dd>
        </div>
        <div class="flex justify-between gap-md pt-sm border-t border-outline-variant/20">
            <dt class="text-on-surface-variant font-label-md">Total paid</dt>
            <dd class="font-headline-sm text-primary">₦{{ number_format($order->total_amount, 0) }}</dd>
        </div>
    </dl>

    <ul class="mt-md space-y-xs font-body-md">
        @foreach ($order->items as $item)
            <li class="flex justify-between gap-md">
                <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                <span class="text-primary font-label-md">₦{{ number_format($item->line_total, 0) }}</span>
            </li>
        @endforeach
    </ul>

    <p class="mt-md font-body-sm text-on-surface-variant">
        A copy of this receipt was sent to {{ $order->email }}.
    </p>
</div>
