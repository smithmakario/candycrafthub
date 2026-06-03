@php
    $bookingModel = $booking ?? null;
@endphp

<form
    method="POST"
    action="{{ $bookingModel ? route('bookings.update', $bookingModel) : route('bookings.store') }}"
    class="max-w-2xl bg-surface-container-lowest rounded-xl border border-outline-variant/20 shadow-sm p-md md:p-xl space-y-md"
>
    @csrf
    @if ($bookingModel)
        @method('PUT')
    @endif

    <div>
        <label for="title" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Event Title</label>
        <input id="title" name="title" type="text" value="{{ old('title', $bookingModel?->title) }}" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
        <div>
            <label for="event_type" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Event Type</label>
            <select id="event_type" name="event_type" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
                @foreach ($eventTypes as $type)
                    <option value="{{ $type->value }}" @selected(old('event_type', $bookingModel?->event_type?->value) === $type->value)>{{ $type->label() }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="status" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Pipeline Status</label>
            <select id="status" name="status" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
                @foreach ($statuses as $status)
                    <option value="{{ $status->value }}" @selected(old('status', $bookingModel?->status?->value) === $status->value)>{{ $status->label() }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
        <div>
            <label for="event_date" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Event Date</label>
            <input id="event_date" name="event_date" type="date" value="{{ old('event_date', $bookingModel?->event_date?->format('Y-m-d')) }}" class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
        </div>
        <div>
            <label for="guest_count" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Guest Count</label>
            <input id="guest_count" name="guest_count" type="number" min="1" value="{{ old('guest_count', $bookingModel?->guest_count) }}" class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
        <div>
            <label for="customer_name" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Customer Name</label>
            <input id="customer_name" name="customer_name" type="text" value="{{ old('customer_name', $bookingModel?->customer_name) }}" class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
        </div>
        <div>
            <label for="customer_email" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Customer Email</label>
            <input id="customer_email" name="customer_email" type="email" value="{{ old('customer_email', $bookingModel?->customer_email) }}" class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
        <div>
            <label for="customer_phone" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Customer Phone</label>
            <input id="customer_phone" name="customer_phone" type="text" value="{{ old('customer_phone', $bookingModel?->customer_phone) }}" class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
        </div>
        <div>
            <label for="theme_color" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Theme Color</label>
            <input id="theme_color" name="theme_color" type="text" placeholder="#864d61" value="{{ old('theme_color', $bookingModel?->theme_color) }}" class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
        <div>
            <label for="progress" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Production Progress (%)</label>
            <input id="progress" name="progress" type="number" min="0" max="100" value="{{ old('progress', $bookingModel?->progress ?? 0) }}" class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
        </div>
        <label class="flex items-center gap-sm text-label-md text-on-surface self-end pb-sm">
            <input type="checkbox" name="is_priority" value="1" @checked(old('is_priority', $bookingModel?->is_priority)) class="rounded border-secondary text-primary focus:ring-primary">
            Mark as priority
        </label>
    </div>

    <div>
        <label for="notes" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Notes</label>
        <textarea id="notes" name="notes" rows="3" class="w-full rounded-xl border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">{{ old('notes', $bookingModel?->notes) }}</textarea>
    </div>

    <div class="flex gap-md pt-md">
        <a href="{{ route('bookings.index') }}" class="flex-1 py-md rounded-full border-2 border-primary text-primary font-bold text-center hover:bg-primary/5 transition-colors">Cancel</a>
        <button type="submit" class="flex-1 py-md rounded-full bg-primary text-on-primary font-bold hover:opacity-90 transition-opacity shadow-md">
            {{ $bookingModel ? 'Update Booking' : 'Create Booking' }}
        </button>
    </div>
</form>
