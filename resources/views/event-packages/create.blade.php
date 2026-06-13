<x-app-layout>
    @include('admin.partials.flash')
    @include('admin.partials.page-header', ['title' => 'Add Event Package', 'subtitle' => 'Create a new event services tier.'])
    @include('event-packages._form')
</x-app-layout>
