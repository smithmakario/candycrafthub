<?php

namespace Tests\Feature;

use App\BookingStatus;
use App\EventType;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_bookings_index(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(route('bookings.index'))
            ->assertOk();
    }

    public function test_authenticated_user_can_create_booking(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->actingAs($user)->post(route('bookings.store'), [
            'title' => 'The Adelaja Nuptials',
            'event_type' => EventType::Wedding->value,
            'status' => BookingStatus::InquiryReceived->value,
            'event_date' => '2026-10-24',
            'guest_count' => 150,
        ]);

        $response->assertRedirect(route('bookings.index'));
        $this->assertDatabaseHas('bookings', [
            'title' => 'The Adelaja Nuptials',
            'status' => BookingStatus::InquiryReceived->value,
        ]);
    }

    public function test_authenticated_user_can_update_booking(): void
    {
        $user = User::factory()->admin()->create();
        $booking = Booking::factory()->status(BookingStatus::Planning)->create();

        $response = $this->actingAs($user)->put(route('bookings.update', $booking), [
            'title' => 'Updated Event',
            'event_type' => $booking->event_type->value,
            'status' => BookingStatus::InProduction->value,
            'progress' => 60,
            'is_priority' => true,
        ]);

        $response->assertRedirect(route('bookings.index'));
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'title' => 'Updated Event',
            'status' => BookingStatus::InProduction->value,
        ]);
    }

    public function test_public_can_submit_event_services_inquiry(): void
    {
        $response = $this->post(route('bookings.store-public'), [
            'event_type' => EventType::Wedding->value,
            'guest_count' => 120,
            'event_date' => now()->addMonth()->toDateString(),
            'theme_color' => '#864d61',
        ]);

        $response->assertRedirect(route('event-services').'#intake-form');
        $this->assertDatabaseHas('bookings', [
            'event_type' => EventType::Wedding->value,
            'status' => BookingStatus::InquiryReceived->value,
        ]);
    }
}
