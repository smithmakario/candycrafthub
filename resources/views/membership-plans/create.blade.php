<x-app-layout>
    @include('admin.partials.flash')
    @include('admin.partials.page-header', ['title' => 'Add Membership Plan', 'subtitle' => 'Create a new subscription tier.'])
    @include('membership-plans._form')
</x-app-layout>
