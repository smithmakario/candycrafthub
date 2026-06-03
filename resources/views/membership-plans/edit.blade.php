<x-app-layout>
    @include('admin.partials.flash')
    @include('admin.partials.page-header', ['title' => 'Edit Membership Plan', 'subtitle' => 'Update plan details and features.'])
    @include('membership-plans._form', ['membershipPlan' => $membershipPlan])
</x-app-layout>
