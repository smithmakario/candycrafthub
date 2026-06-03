<x-app-layout>
    @include('admin.partials.flash')

    @include('admin.partials.page-header', [
        'title' => 'Add Product',
        'subtitle' => 'Create a new catalog item.',
    ])

    @include('products._form', ['origins' => $origins])
</x-app-layout>
