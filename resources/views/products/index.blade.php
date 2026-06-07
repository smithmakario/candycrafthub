<x-app-layout>
    @include('admin.partials.flash')

    @include('admin.partials.page-header', [
        'title' => 'Products',
        'subtitle' => 'Manage your confectionery catalog.',
        'actionUrl' => route('products.create'),
        'actionLabel' => 'Add Product',
    ])

    <div class="bg-surface-container-lowest rounded-xl overflow-x-auto border border-outline-variant/20 shadow-sm">
        <table class="w-full min-w-[720px] text-left">
            <thead>
                <tr class="bg-surface-container text-on-surface-variant text-label-md">
                    <th class="px-md py-sm align-middle">Image</th>
                    <th class="px-md py-sm align-middle">Name</th>
                    <th class="px-md py-sm align-middle">SKU</th>
                    <th class="px-md py-sm align-middle">Origin</th>
                    <th class="px-md py-sm align-middle">Category</th>
                    <th class="px-md py-sm align-middle">Unit Price</th>
                    <th class="px-md py-sm align-middle">Status</th>
                    <th class="px-md py-sm align-middle text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-body-md">
                @forelse ($products as $product)
                    <tr class="border-b border-outline-variant/10 hover:bg-surface/50 transition-colors">
                        <td class="px-md py-md align-middle">
                            @if ($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover border border-outline-variant/20">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-surface-container flex items-center justify-center border border-outline-variant/20">
                                    <span class="material-symbols-outlined text-on-surface-variant">image</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-md py-md align-middle font-semibold">{{ $product->name }}</td>
                        <td class="px-md py-md align-middle">{{ $product->sku ?? '—' }}</td>
                        <td class="px-md py-md align-middle">{{ $product->origin->label() }}</td>
                        <td class="px-md py-md align-middle">{{ $product->category?->name ?? '—' }}</td>
                        <td class="px-md py-md align-middle">₦{{ number_format($product->unit_price, 0) }}</td>
                        <td class="px-md py-md align-middle">
                            <span @class([
                                'inline-flex px-sm py-1 rounded-full text-label-sm whitespace-nowrap',
                                'bg-secondary-container text-on-secondary-container' => $product->is_active,
                                'bg-surface-container text-on-surface-variant' => ! $product->is_active,
                            ])>
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-md py-md align-middle">
                            <div class="flex justify-end gap-sm">
                                <a href="{{ route('products.show', $product) }}" class="text-primary hover:underline text-label-sm">View</a>
                                <a href="{{ route('products.edit', $product) }}" class="text-primary hover:underline text-label-sm">Edit</a>
                                <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-error hover:underline text-label-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-md py-xl text-center text-on-surface-variant">No products yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($products->hasPages())
        <div class="mt-md">{{ $products->links() }}</div>
    @endif
</x-app-layout>
