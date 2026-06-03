<x-app-layout>
    @include('admin.partials.flash')

    @include('admin.partials.page-header', [
        'title' => 'Edit Product',
        'subtitle' => 'Update catalog details.',
    ])

    @include('products._form', ['product' => $product, 'origins' => $origins])
</x-app-layout>
