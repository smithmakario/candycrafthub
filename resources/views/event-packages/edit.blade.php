<x-app-layout>
    @include('admin.partials.flash')
    @include('admin.partials.page-header', ['title' => 'Edit Event Package', 'subtitle' => $eventPackage->name])
    @include('event-packages._form', ['eventPackage' => $eventPackage])
</x-app-layout>
