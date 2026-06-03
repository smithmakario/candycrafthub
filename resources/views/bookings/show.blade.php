<x-app-layout>
    @include('admin.partials.flash')

    @include('admin.partials.page-header', [
        'title' => $booking->title,
        'subtitle' => $booking->status->label().' · '.$booking->event_type->label(),
        'actionUrl' => route('bookings.edit', $booking),
        'actionLabel' => 'Edit Booking',
    ])

    <div class="max-w-xl bg-surface-container-lowest rounded-xl border border-outline-variant/20 shadow-sm p-md space-y-sm">
        <p><span class="text-on-surface-variant">Event date:</span> {{ $booking->event_date?->format('M d, Y') ?? '—' }}</p>
        <p><span class="text-on-surface-variant">Guests:</span> {{ $booking->guest_count ?? '—' }}</p>
        <p><span class="text-on-surface-variant">Customer:</span> {{ $booking->customer_name ?? '—' }}</p>
        <p><span class="text-on-surface-variant">Email:</span> {{ $booking->customer_email ?? '—' }}</p>
        <p><span class="text-on-surface-variant">Phone:</span> {{ $booking->customer_phone ?? '—' }}</p>
        <p><span class="text-on-surface-variant">Theme:</span> {{ $booking->theme_color ?? '—' }}</p>
        @if ($booking->notes)
            <p class="pt-sm text-on-surface-variant">{{ $booking->notes }}</p>
        @endif
    </div>
</x-app-layout>
