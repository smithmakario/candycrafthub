<x-app-layout>
    @include('admin.partials.flash')
    @include('admin.partials.page-header', ['title' => 'New Booking', 'subtitle' => 'Add an event to the pipeline.'])
    @include('bookings._form', ['eventTypes' => $eventTypes, 'statuses' => $statuses])
</x-app-layout>
