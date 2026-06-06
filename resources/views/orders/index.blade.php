<x-app-layout>
    @include('admin.partials.flash')

    @include('admin.partials.page-header', [
        'title' => 'Transactions',
        'subtitle' => 'All shop orders and payment activity.',
    ])

    @if ($pendingApprovalCount > 0)
        <div class="mb-lg rounded-xl border border-primary/30 bg-primary-container/20 px-md py-md">
            <p class="font-label-md text-on-surface">
                {{ $pendingApprovalCount }} bank transfer {{ $pendingApprovalCount === 1 ? 'payment is' : 'payments are' }} awaiting your approval.
            </p>
        </div>
    @endif

    <div class="bg-surface-container-lowest rounded-xl overflow-x-auto border border-outline-variant/20 shadow-sm">
        <table class="w-full min-w-[1080px] text-left">
            <thead>
                <tr class="bg-surface-container text-on-surface-variant text-label-md">
                    <th class="px-md py-sm align-middle">Reference</th>
                    <th class="px-md py-sm align-middle">Customer</th>
                    <th class="px-md py-sm align-middle">Payment</th>
                    <th class="px-md py-sm align-middle">Paid to</th>
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
                    <tr @class([
                        'border-b border-outline-variant/10 hover:bg-surface/50 transition-colors',
                        'bg-primary-container/10' => $order->isPendingApproval(),
                    ])>
                        <td class="px-md py-md align-middle font-semibold">#{{ $order->reference }}</td>
                        <td class="px-md py-md align-middle">
                            <div class="flex flex-col">
                                <span>{{ $order->user?->name ?? 'Guest' }}</span>
                                <span class="text-label-sm text-on-surface-variant">{{ $order->email }}</span>
                            </div>
                        </td>
                        <td class="px-md py-md align-middle">{{ $order->payment_method->label() }}</td>
                        <td class="px-md py-md align-middle">
                            {{ $order->paidToBankAccountLabel() ?? '—' }}
                        </td>
                        <td class="px-md py-md align-middle">{{ $order->created_at->format('M j, Y') }}</td>
                        <td class="px-md py-md align-middle">{{ (int) ($order->items_quantity ?? 0) }}</td>
                        <td class="px-md py-md align-middle">₦{{ number_format($order->total_amount, 0) }}</td>
                        <td class="px-md py-md align-middle">
                            <span @class([
                                'inline-flex px-sm py-1 rounded-full text-label-sm whitespace-nowrap',
                                'bg-secondary-container text-on-secondary-container' => $order->isPaid(),
                                'bg-error-container text-on-error-container' => $order->status === \App\OrderStatus::Failed,
                                'bg-primary-container text-on-primary-container' => $order->isPendingApproval(),
                                'bg-surface-container text-on-surface-variant' => $order->status === \App\OrderStatus::Pending && ! $order->isPendingApproval(),
                            ])>
                                {{ $order->statusLabel() }}
                            </span>
                        </td>
                        <td class="px-md py-md align-middle">
                            {{ $order->paid_at?->format('M j, Y g:i A') ?? '—' }}
                        </td>
                        <td class="px-md py-md align-middle text-right">
                            <div class="flex justify-end items-center gap-sm">
                                <a href="{{ route('orders.show', $order) }}" class="text-primary hover:underline text-label-sm">View</a>
                                @if ($order->isPendingApproval())
                                    <form method="POST" action="{{ route('orders.confirm-payment', $order) }}"
                                        onsubmit="return confirm('Confirm that payment has been received for this order?')">
                                        @csrf
                                        <button type="submit" class="text-secondary hover:underline text-label-sm">Approve</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-md py-xl text-center text-on-surface-variant">
                            No transactions yet.
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
