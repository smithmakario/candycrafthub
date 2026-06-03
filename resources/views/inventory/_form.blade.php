@php
    $itemModel = $inventoryItem ?? null;
@endphp

<form
    method="POST"
    action="{{ $itemModel ? route('inventory.update', $itemModel) : route('inventory.store') }}"
    class="max-w-2xl bg-surface-container-lowest rounded-xl border border-outline-variant/20 shadow-sm p-md md:p-xl space-y-md"
>
    @csrf
    @if ($itemModel)
        @method('PUT')
    @endif

    @if ($itemModel)
        <div class="rounded-xl bg-surface-container-high px-md py-sm text-label-md">
            Product: <strong>{{ $itemModel->product->name }}</strong>
        </div>
    @else
        <div>
            <label for="product_id" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Product</label>
            <select id="product_id" name="product_id" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
                <option value="">Select a product</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>{{ $product->name }}</option>
                @endforeach
            </select>
            @if ($products->isEmpty())
                <p class="text-label-sm text-on-surface-variant mt-xs">
                    All products already have inventory.
                    <a href="{{ route('products.create') }}" class="text-primary underline">Create a product first</a>.
                </p>
            @endif
        </div>
    @endif

    <div>
        <label for="quantity" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Stock Quantity</label>
        <input id="quantity" name="quantity" type="number" min="0" value="{{ old('quantity', $itemModel?->quantity ?? 0) }}" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
    </div>

    <div>
        <label for="low_stock_threshold" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Low Stock Threshold</label>
        <input id="low_stock_threshold" name="low_stock_threshold" type="number" min="0" value="{{ old('low_stock_threshold', $itemModel?->low_stock_threshold ?? 50) }}" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
    </div>

    <div>
        <label for="notes" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Notes</label>
        <textarea id="notes" name="notes" rows="3" class="w-full rounded-xl border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">{{ old('notes', $itemModel?->notes) }}</textarea>
    </div>

    <div class="flex gap-md pt-md">
        <a href="{{ route('inventory.index') }}" class="flex-1 py-md rounded-full border-2 border-primary text-primary font-bold text-center hover:bg-primary/5 transition-colors">Cancel</a>
        <button type="submit" class="flex-1 py-md rounded-full bg-primary text-on-primary font-bold hover:opacity-90 transition-opacity shadow-md">
            {{ $itemModel ? 'Update Inventory' : 'Create Inventory Record' }}
        </button>
    </div>
</form>
