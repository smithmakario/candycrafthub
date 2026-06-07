<x-app-layout>
    @include('admin.partials.flash')

    @include('admin.partials.page-header', [
        'title' => $product->name,
        'subtitle' => 'Product details and inventory link.',
        'actionUrl' => route('products.edit', $product),
        'actionLabel' => 'Edit Product',
    ])

    <div class="grid grid-cols-1 md:grid-cols-2 gap-xl max-w-4xl">
        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/20 shadow-sm overflow-hidden">
            @if ($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-56 object-cover">
            @else
                <div class="w-full h-56 bg-surface-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-[64px] text-on-surface-variant">image</span>
                </div>
            @endif
            <div class="p-md space-y-sm">
            <p><span class="text-on-surface-variant">SKU:</span> {{ $product->sku ?? '—' }}</p>
            <p><span class="text-on-surface-variant">Origin:</span> {{ $product->origin->label() }}</p>
            <p><span class="text-on-surface-variant">Category:</span> {{ $product->category?->name ?? '—' }}</p>
            <p><span class="text-on-surface-variant">Unit Price:</span> ₦{{ number_format($product->unit_price, 0) }}</p>
            <p><span class="text-on-surface-variant">Status:</span> {{ $product->is_active ? 'Active' : 'Inactive' }}</p>
            @if ($product->description)
                <p class="pt-sm text-on-surface-variant">{{ $product->description }}</p>
            @endif
            </div>
        </div>

        <div class="bg-surface-container-high rounded-xl p-md">
            <h3 class="text-headline-sm font-headline-sm text-on-surface mb-md">Inventory</h3>
            @if ($product->inventoryItem)
                <p class="text-body-md mb-sm">Stock: <strong>{{ number_format($product->inventoryItem->quantity) }} units</strong></p>
                <p class="text-body-md mb-md">Low stock threshold: {{ number_format($product->inventoryItem->low_stock_threshold) }}</p>
                <a href="{{ route('inventory.edit', $product->inventoryItem) }}" class="text-primary font-bold hover:underline">Manage inventory</a>
            @else
                <p class="text-on-surface-variant mb-md">No inventory record yet.</p>
                <a href="{{ route('inventory.create') }}" class="text-primary font-bold hover:underline">Add inventory record</a>
            @endif
        </div>
    </div>
</x-app-layout>
