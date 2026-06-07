<x-app-layout>
    @include('admin.partials.flash')

    @include('admin.partials.page-header', [
        'title' => $category->name,
        'subtitle' => $category->description ?? 'Product category',
        'actionUrl' => route('categories.edit', $category),
        'actionLabel' => 'Edit Category',
    ])

    <div class="max-w-xl bg-surface-container-lowest rounded-xl border border-outline-variant/20 shadow-sm p-md space-y-md">
        <p><span class="text-on-surface-variant">Slug:</span> {{ $category->slug }}</p>
        <p><span class="text-on-surface-variant">Products:</span> {{ $category->products_count }}</p>
        <p><span class="text-on-surface-variant">Display order:</span> {{ $category->sort_order }}</p>
        <p><span class="text-on-surface-variant">Status:</span> {{ $category->is_active ? 'Active' : 'Hidden' }}</p>
        @if ($category->description)
            <p><span class="text-on-surface-variant">Description:</span> {{ $category->description }}</p>
        @endif
    </div>
</x-app-layout>
