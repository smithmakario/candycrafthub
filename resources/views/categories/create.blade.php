<x-app-layout>
    @include('admin.partials.flash')
    @include('admin.partials.page-header', ['title' => 'Add Category', 'subtitle' => 'Create a new product category.'])
    @include('categories._form')
</x-app-layout>
