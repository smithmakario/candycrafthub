<x-app-layout>
    @include('admin.partials.flash')

    @include('admin.partials.page-header', [
        'title' => $inventoryItem->product->name,
        'subtitle' => 'Inventory record details.',
        'actionUrl' => route('inventory.edit', $inventoryItem),
        'actionLabel' => 'Edit Inventory',
    ])

    <div class="max-w-xl bg-surface-container-lowest rounded-xl border border-outline-variant/20 shadow-sm p-md space-y-sm">
        <p><span class="text-on-surface-variant">Origin:</span> {{ $inventoryItem->product->origin->label() }}</p>
        <p><span class="text-on-surface-variant">Quantity:</span> {{ number_format($inventoryItem->quantity) }} units</p>
        <p><span class="text-on-surface-variant">Low stock threshold:</span> {{ number_format($inventoryItem->low_stock_threshold) }}</p>
        <p><span class="text-on-surface-variant">Status:</span> {{ $inventoryItem->stockStatusLabel() }}</p>
        <p><span class="text-on-surface-variant">Unit price:</span> ₦{{ number_format($inventoryItem->product->unit_price, 0) }}</p>
        @if ($inventoryItem->notes)
            <p class="pt-sm text-on-surface-variant">{{ $inventoryItem->notes }}</p>
        @endif
    </div>
</x-app-layout>
