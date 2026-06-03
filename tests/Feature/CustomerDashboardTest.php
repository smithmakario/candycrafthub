<?php

namespace Tests\Feature;

use App\BookingStatus;
use App\EventType;
use App\FulfillmentType;
use App\Models\Booking;
use App\Models\MembershipPlan;
use App\Models\Order;
use App\Models\User;
use App\OrderStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_dashboard_shows_orders_and_membership_plans(): void
    {
        $user = User::factory()->customer()->create();

        $order = Order::query()->create([
            'user_id' => $user->id,
            'email' => $user->email,
            'fulfillment_type' => FulfillmentType::Pickup,
            'reference' => 'CCH-TEST-001',
            'status' => OrderStatus::Paid,
            'total_amount' => 5000,
            'currency' => 'NGN',
            'paid_at' => now(),
        ]);

        MembershipPlan::factory()->create([
            'name' => 'The Explorer',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get(route('customer.dashboard'));

        $response->assertOk();
        $response->assertSee('Previous Orders');
        $response->assertSee($order->reference);
        $response->assertSee('Membership Plans');
        $response->assertSee('The Explorer');
    }

    public function test_customer_dashboard_shows_bookings_linked_to_user(): void
    {
        $user = User::factory()->customer()->create();

        $booking = Booking::query()->create([
            'user_id' => $user->id,
            'title' => 'Wedding Inquiry',
            'event_type' => EventType::Wedding,
            'status' => BookingStatus::Planning,
            'event_date' => now()->addMonth(),
            'guest_count' => 150,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
        ]);

        $response = $this->actingAs($user)->get(route('customer.dashboard'));

        $response->assertOk();
        $response->assertSee('Event Bookings');
        $response->assertSee($booking->title);
        $response->assertSee('Planning');
    }

    public function test_customer_dashboard_includes_bookings_by_email(): void
    {
        $user = User::factory()->customer()->create();

        $booking = Booking::query()->create([
            'title' => 'Birthday Inquiry',
            'event_type' => EventType::Birthday,
            'status' => BookingStatus::InquiryReceived,
            'customer_email' => $user->email,
            'customer_name' => $user->name,
        ]);

        $response = $this->actingAs($user)->get(route('customer.dashboard'));

        $response->assertOk();
        $response->assertSee($booking->title);
    }

    public function test_customer_dashboard_includes_orders_by_email(): void
    {
        $user = User::factory()->customer()->create();

        $order = Order::query()->create([
            'user_id' => null,
            'email' => $user->email,
            'fulfillment_type' => FulfillmentType::Pickup,
            'reference' => 'CCH-GUEST-001',
            'status' => OrderStatus::Pending,
            'total_amount' => 2500,
            'currency' => 'NGN',
        ]);

        $response = $this->actingAs($user)->get(route('customer.dashboard'));

        $response->assertOk();
        $response->assertSee($order->reference);
    }
}
