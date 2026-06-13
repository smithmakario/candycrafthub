<?php

namespace App\Http\Controllers;

use App\BookingStatus;
use App\EventType;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\StorePublicBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookingsByStatus = collect(BookingStatus::pipelineOrder())
            ->mapWithKeys(fn (BookingStatus $status): array => [
                $status->value => Booking::query()
                    ->status($status)
                    ->orderByDesc('event_date')
                    ->orderByDesc('id')
                    ->get(),
            ]);

        return view('bookings.index', [
            'bookingsByStatus' => $bookingsByStatus,
            'statuses' => BookingStatus::pipelineOrder(),
        ]);
    }

    public function create(): View
    {
        return view('bookings.create', [
            'eventTypes' => EventType::cases(),
            'statuses' => BookingStatus::cases(),
        ]);
    }

    public function store(StoreBookingRequest $request): RedirectResponse
    {
        Booking::query()->create($this->validatedBookingData($request->validated()));

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    public function show(Booking $booking): View
    {
        return view('bookings.show', [
            'booking' => $booking,
        ]);
    }

    public function edit(Booking $booking): View
    {
        return view('bookings.edit', [
            'booking' => $booking,
            'eventTypes' => EventType::cases(),
            'statuses' => BookingStatus::cases(),
        ]);
    }

    public function update(UpdateBookingRequest $request, Booking $booking): RedirectResponse
    {
        $booking->update($this->validatedBookingData($request->validated()));

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }

    public function complete(Booking $booking): RedirectResponse
    {
        if ($booking->status !== BookingStatus::InProduction) {
            return redirect()
                ->route('bookings.index')
                ->with('error', 'Only in-production bookings can be marked complete.');
        }

        $booking->update([
            'status' => BookingStatus::Completed,
            'progress' => 100,
        ]);

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Booking marked as completed.');
    }

    public function storePublic(StorePublicBookingRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Booking::query()->create([
            'user_id' => $request->user()?->id,
            'title' => EventType::from($validated['event_type'])->label().' Inquiry',
            'event_type' => $validated['event_type'],
            'status' => BookingStatus::InquiryReceived,
            'event_date' => $validated['event_date'] ?? null,
            'guest_count' => $validated['guest_count'] ?? null,
            'theme_color' => $validated['theme_color'] ?? null,
            'customer_name' => $validated['customer_name'] ?? null,
            'customer_email' => $validated['customer_email'] ?? null,
            'customer_phone' => $validated['customer_phone'] ?? null,
            'progress' => 0,
            'is_priority' => false,
        ]);

        return redirect()
            ->route('event-services')
            ->withFragment('intake-form')
            ->with('booking_success', true);
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function validatedBookingData(array $validated): array
    {
        $validated['is_priority'] = (bool) ($validated['is_priority'] ?? false);

        if (($validated['status'] ?? null) !== BookingStatus::InProduction->value) {
            $validated['progress'] = ($validated['status'] ?? null) === BookingStatus::Completed->value ? 100 : 0;
        }

        return $validated;
    }
}
