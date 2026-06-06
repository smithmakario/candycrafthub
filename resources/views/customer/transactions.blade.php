<x-app-layout>
    <header class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-md mb-xl">
        <div>
            <h2 class="text-display-lg font-display-lg text-primary">My Transactions</h2>
            <p class="text-body-lg text-on-surface-variant">Your complete order and payment history.</p>
        </div>
        <a href="{{ route('shop') }}" class="bg-primary text-on-primary px-md py-sm rounded-full font-label-md flex items-center gap-sm hover:scale-105 transition-transform shadow-sm shrink-0">
            <span class="material-symbols-outlined">shopping_bag</span>
            Continue Shopping
        </a>
    </header>

    <div class="bg-surface-container-lowest rounded-xl overflow-x-auto border border-outline-variant/20 shadow-sm">
        <table class="w-full min-w-[720px] text-left">
            <thead>
                <tr class="bg-surface-container text-on-surface-variant text-label-md">
                    <th class="px-md py-sm align-middle">Order</th>
                    <th class="px-md py-sm align-middle">Date</th>
                    <th class="px-md py-sm align-middle">Items</th>
                    <th class="px-md py-sm align-middle">Total</th>
                    <th class="px-md py-sm align-middle">Status</th>
                    <th class="px-md py-sm align-middle">Paid At</th>
                    <th class="px-md py-sm align-middle text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-body-md">
                @forelse ($orders as $order)
                    <tr class="border-b border-outline-variant/10 hover:bg-surface/50 transition-colors">
                        <td class="px-md py-md align-middle font-semibold">#{{ $order->reference }}</td>
                        <td class="px-md py-md align-middle">{{ $order->created_at->format('M j, Y') }}</td>
                        <td class="px-md py-md align-middle">{{ (int) ($order->items_quantity ?? 0) }}</td>
                        <td class="px-md py-md align-middle">₦{{ number_format($order->total_amount, 0) }}</td>
                        <td class="px-md py-md align-middle">
                            <span @class([
                                'inline-flex px-sm py-1 rounded-full text-label-sm whitespace-nowrap',
                                'bg-secondary-container text-on-secondary-container' => $order->isPaid(),
                                'bg-error-container text-on-error-container' => $order->status === \App\OrderStatus::Failed,
                                'bg-surface-container text-on-surface-variant' => $order->status === \App\OrderStatus::Pending,
                            ])>
                                {{ $order->statusLabel() }}
                            </span>
                        </td>
                        <td class="px-md py-md align-middle">
                            {{ $order->paid_at?->format('M j, Y g:i A') ?? '—' }}
                        </td>
                        <td class="px-md py-md align-middle text-right">
                            <a href="{{ route('orders.show', $order) }}" class="text-primary hover:underline text-label-sm">View</a>
                                @if ($order->status === \App\OrderStatus::Pending && ! $order->isBankTransfer())
                                    <a href="{{ route('payment.initiate', $order) }}" class="text-primary hover:underline text-label-sm ml-sm">Pay</a>
                                @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-md py-xl text-center text-on-surface-variant">
                            No transactions yet. <a href="{{ route('shop') }}" class="text-primary underline">Browse the shop</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($orders->hasPages())
        <div class="mt-md">{{ $orders->links() }}</div>
    @endif
</x-app-layout>
