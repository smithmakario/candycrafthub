@props(['booking'])

<div @class([
    'bg-surface-container-lowest p-md rounded-xl shadow-sm border border-outline-variant/10 cursor-pointer transition-colors',
    'hover:border-primary/40 group' => $booking->status !== \App\BookingStatus::Completed,
    'opacity-60' => $booking->status === \App\BookingStatus::Completed,
    'ring-2 ring-primary/20' => $booking->is_priority,
])>
    <div class="flex justify-between items-start gap-sm">
        <p @class(['text-label-sm mb-xs', $booking->event_type->colorClass()])>{{ $booking->event_type->label() }}</p>
        @if ($booking->is_priority)
            <span class="material-symbols-outlined text-primary text-sm shrink-0">priority_high</span>
        @endif
    </div>
    <h5 class="text-label-md font-bold mb-md">{{ $booking->title }}</h5>

    @if ($booking->status === \App\BookingStatus::InProduction)
        <div class="w-full bg-surface-container rounded-full h-2 mb-md">
            <div class="bg-primary h-full rounded-full" style="width: {{ $booking->progress }}%"></div>
        </div>
        <div class="flex justify-between items-center gap-sm">
            <span class="text-label-sm text-on-surface-variant">{{ $booking->progress }}% Complete</span>
            <div class="flex items-center gap-sm shrink-0">
                <a href="{{ route('bookings.edit', $booking) }}" class="text-primary text-label-sm hover:underline">Edit</a>
                <form method="POST" action="{{ route('bookings.complete', $booking) }}" class="inline"
                    onsubmit="return confirm('Mark this booking as completed?')">
                    @csrf
                    <button type="submit" class="text-secondary text-label-sm hover:underline font-bold">Complete</button>
                </form>
            </div>
        </div>
    @elseif ($booking->status === \App\BookingStatus::Completed)
        <span class="text-label-sm text-secondary font-bold flex items-center gap-xs">
            <span class="material-symbols-outlined text-[16px]">check_circle</span>
            Delivered
        </span>
    @else
        <div class="flex justify-between items-center gap-sm">
            @if ($booking->event_date)
                <span class="text-label-sm text-on-surface-variant flex items-center gap-xs">
                    <span class="material-symbols-outlined text-[16px]">calendar_month</span>
                    {{ $booking->event_date->format('M d') }}
                </span>
            @endif
            <a href="{{ route('bookings.edit', $booking) }}" class="text-primary text-label-sm hover:underline shrink-0">Edit</a>
        </div>
    @endif
</div>
