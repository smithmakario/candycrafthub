<x-app-layout>
    @include('admin.partials.flash')
    @include('admin.partials.page-header', ['title' => 'Edit Inventory', 'subtitle' => 'Adjust stock levels and thresholds.'])
    @include('inventory._form', ['inventoryItem' => $inventoryItem])
</x-app-layout>
