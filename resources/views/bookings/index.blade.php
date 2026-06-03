<x-app-layout>
    @include('admin.partials.flash')

    @include('admin.partials.page-header', [
        'title' => 'Event Bookings',
        'subtitle' => 'Manage your event pipeline from inquiry to delivery.',
        'actionUrl' => route('bookings.create'),
        'actionLabel' => 'New Booking',
    ])

    <div class="flex gap-gutter overflow-x-auto pb-md custom-scrollbar min-h-[450px]">
        @foreach ($statuses as $status)
            @php
                $bookings = $bookingsByStatus[$status->value];
            @endphp
            <div class="flex flex-col gap-sm min-w-[280px] flex-1">
                <div class="flex items-center gap-sm px-sm min-h-[28px]">
                    <div @class(['w-2 h-2 rounded-full shrink-0', $status->dotColorClass()])></div>
                    <h4 class="text-label-md font-bold text-on-surface-variant">{{ $status->label() }} ({{ $bookings->count() }})</h4>
                </div>
                <div class="flex flex-col gap-md bg-surface-container/30 p-sm rounded-xl flex-1 border border-dashed border-outline-variant">
                    @forelse ($bookings as $booking)
                        @include('bookings.partials.card', ['booking' => $booking])
                    @empty
                        <p class="text-label-sm text-on-surface-variant text-center py-md">No bookings in this stage.</p>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
