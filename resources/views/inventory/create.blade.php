<x-app-layout>
    @include('admin.partials.flash')
    @include('admin.partials.page-header', ['title' => 'Add Inventory', 'subtitle' => 'Link stock levels to a product.'])
    @include('inventory._form', ['products' => $products])
</x-app-layout>
