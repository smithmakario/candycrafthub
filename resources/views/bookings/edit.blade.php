<x-app-layout>
    @include('admin.partials.flash')
    @include('admin.partials.page-header', ['title' => 'Edit Booking', 'subtitle' => 'Update pipeline details for this event.'])
    @include('bookings._form', ['booking' => $booking, 'eventTypes' => $eventTypes, 'statuses' => $statuses])
</x-app-layout>
