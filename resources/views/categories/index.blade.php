<x-app-layout>
    @include('admin.partials.flash')

    @include('admin.partials.page-header', [
        'title' => 'Categories',
        'subtitle' => 'Organize products into shop and catalog groupings.',
        'actionUrl' => route('categories.create'),
        'actionLabel' => 'Add Category',
    ])

    <div class="bg-surface-container-lowest rounded-xl overflow-x-auto border border-outline-variant/20 shadow-sm">
        <table class="w-full min-w-[720px] text-left">
            <thead>
                <tr class="bg-surface-container text-on-surface-variant text-label-md">
                    <th class="px-md py-sm align-middle">Name</th>
                    <th class="px-md py-sm align-middle">Products</th>
                    <th class="px-md py-sm align-middle">Order</th>
                    <th class="px-md py-sm align-middle">Status</th>
                    <th class="px-md py-sm align-middle text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-body-md">
                @forelse ($categories as $category)
                    <tr class="border-b border-outline-variant/10 hover:bg-surface/50 transition-colors">
                        <td class="px-md py-md align-middle">
                            <p class="font-semibold">{{ $category->name }}</p>
                            @if ($category->description)
                                <p class="text-on-surface-variant text-label-sm mt-xs">{{ Str::limit($category->description, 60) }}</p>
                            @endif
                        </td>
                        <td class="px-md py-md align-middle">{{ $category->products_count }}</td>
                        <td class="px-md py-md align-middle">{{ $category->sort_order }}</td>
                        <td class="px-md py-md align-middle">
                            <span @class([
                                'inline-flex px-sm py-1 rounded-full text-label-sm whitespace-nowrap',
                                'bg-secondary-container text-on-secondary-container' => $category->is_active,
                                'bg-surface-container text-on-surface-variant' => ! $category->is_active,
                            ])>
                                {{ $category->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </td>
                        <td class="px-md py-md align-middle">
                            <div class="flex justify-end gap-sm">
                                <a href="{{ route('categories.show', $category) }}" class="text-primary hover:underline text-label-sm">View</a>
                                <a href="{{ route('categories.edit', $category) }}" class="text-primary hover:underline text-label-sm">Edit</a>
                                <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-error hover:underline text-label-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-md py-xl text-center text-on-surface-variant">No categories yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($categories->hasPages())
        <div class="mt-md">{{ $categories->links() }}</div>
    @endif
</x-app-layout>
