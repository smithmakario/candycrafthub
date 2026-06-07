<x-app-layout>
    @include('admin.partials.flash')
    @include('admin.partials.page-header', ['title' => 'Edit Category', 'subtitle' => 'Update category details and visibility.'])
    @include('categories._form', ['category' => $category])
</x-app-layout>
