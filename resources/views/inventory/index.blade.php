<x-app-layout>
    @include('admin.partials.flash')

    @include('admin.partials.page-header', [
        'title' => 'Inventory',
        'subtitle' => 'Track stock levels across your catalog.',
        'actionUrl' => route('inventory.create'),
        'actionLabel' => 'Add Stock Record',
    ])

    <div class="flex flex-wrap gap-xs mb-md">
        <a href="{{ route('inventory.index') }}" @class([
            'text-label-sm px-md py-1 rounded-full transition-colors',
            'bg-primary text-on-primary' => ! $activeOrigin,
            'bg-surface-container text-on-surface-variant hover:bg-surface-variant' => $activeOrigin,
        ])>All</a>
        @foreach ($origins as $origin)
            <a href="{{ route('inventory.index', ['origin' => $origin->value]) }}" @class([
                'text-label-sm px-md py-1 rounded-full transition-colors',
                'bg-primary text-on-primary' => $activeOrigin === $origin,
                'bg-surface-container text-on-surface-variant hover:bg-surface-variant' => $activeOrigin !== $origin,
            ])>{{ $origin === \App\ProductOrigin::LocalNostalgia ? 'Local' : 'Imports' }}</a>
        @endforeach
    </div>

    <div class="bg-surface-container-lowest rounded-xl overflow-x-auto border border-outline-variant/20 shadow-sm">
        <table class="w-full min-w-[720px] text-left">
            <thead>
                <tr class="bg-surface-container text-on-surface-variant text-label-md">
                    <th class="px-md py-sm align-middle">Product Name</th>
                    <th class="px-md py-sm align-middle">Origin</th>
                    <th class="px-md py-sm align-middle">Stock Level</th>
                    <th class="px-md py-sm align-middle">Unit Price</th>
                    <th class="px-md py-sm align-middle">Status</th>
                    <th class="px-md py-sm align-middle text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-body-md">
                @forelse ($inventoryItems as $item)
                    <tr class="border-b border-outline-variant/10 hover:bg-surface/50 transition-colors">
                        <td class="px-md py-md align-middle font-semibold">{{ $item->product->name }}</td>
                        <td class="px-md py-md align-middle">{{ $item->product->origin->label() }}</td>
                        <td class="px-md py-md align-middle">{{ number_format($item->quantity) }} units</td>
                        <td class="px-md py-md align-middle">₦{{ number_format($item->product->unit_price, 0) }}</td>
                        <td class="px-md py-md align-middle">
                            <span @class([
                                'inline-flex px-sm py-1 rounded-full text-label-sm whitespace-nowrap',
                                'bg-secondary-container text-on-secondary-container' => ! $item->isLowStock(),
                                'bg-error-container text-on-error-container' => $item->isLowStock(),
                            ])>
                                {{ $item->stockStatusLabel() }}
                            </span>
                        </td>
                        <td class="px-md py-md align-middle">
                            <div class="flex justify-end gap-sm">
                                <a href="{{ route('inventory.show', $item) }}" class="text-primary hover:underline text-label-sm">View</a>
                                <a href="{{ route('inventory.edit', $item) }}" class="text-primary hover:underline text-label-sm">Edit</a>
                                <form method="POST" action="{{ route('inventory.destroy', $item) }}" onsubmit="return confirm('Delete this inventory record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-error hover:underline text-label-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-md py-xl text-center text-on-surface-variant">No inventory records yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($inventoryItems->hasPages())
        <div class="mt-md">{{ $inventoryItems->links() }}</div>
    @endif
</x-app-layout>
