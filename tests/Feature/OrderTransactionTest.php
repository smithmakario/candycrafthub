<?php

namespace Tests\Feature;

use App\FulfillmentType;
use App\Models\Order;
use App\Models\User;
use App\OrderStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_all_transactions(): void
    {
        $admin = User::factory()->admin()->create();
        $customer = User::factory()->customer()->create();

        $order = Order::query()->create([
            'user_id' => $customer->id,
            'email' => $customer->email,
            'fulfillment_type' => FulfillmentType::Pickup,
            'reference' => 'CCH-ADMIN-001',
            'status' => OrderStatus::Paid,
            'total_amount' => 7500,
            'currency' => 'NGN',
            'paid_at' => now(),
        ]);

        $response = $this->actingAs($admin)->get(route('orders.index'));

        $response->assertOk();
        $response->assertSee('Transactions');
        $response->assertSee($order->reference);
        $response->assertSee($customer->email);
    }

    public function test_customer_can_view_their_transactions(): void
    {
        $user = User::factory()->customer()->create();

        $order = Order::query()->create([
            'user_id' => $user->id,
            'email' => $user->email,
            'fulfillment_type' => FulfillmentType::Pickup,
            'reference' => 'CCH-CUST-001',
            'status' => OrderStatus::Paid,
            'total_amount' => 5000,
            'currency' => 'NGN',
            'paid_at' => now(),
        ]);

        $otherOrder = Order::query()->create([
            'user_id' => null,
            'email' => 'other@example.com',
            'fulfillment_type' => FulfillmentType::Pickup,
            'reference' => 'CCH-OTHER-001',
            'status' => OrderStatus::Paid,
            'total_amount' => 3000,
            'currency' => 'NGN',
            'paid_at' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('customer.transactions'));

        $response->assertOk();
        $response->assertSee('My Transactions');
        $response->assertSee($order->reference);
        $response->assertDontSee($otherOrder->reference);
    }

    public function test_customer_transactions_include_orders_by_email(): void
    {
        $user = User::factory()->customer()->create();

        $order = Order::query()->create([
            'user_id' => null,
            'email' => $user->email,
            'fulfillment_type' => FulfillmentType::Pickup,
            'reference' => 'CCH-GUEST-002',
            'status' => OrderStatus::Pending,
            'total_amount' => 2500,
            'currency' => 'NGN',
        ]);

        $response = $this->actingAs($user)->get(route('customer.transactions'));

        $response->assertOk();
        $response->assertSee($order->reference);
    }

    public function test_customer_cannot_access_admin_transactions(): void
    {
        $user = User::factory()->customer()->create();

        $response = $this->actingAs($user)->get(route('orders.index'));

        $response->assertRedirect(route('customer.dashboard'));
    }

    public function test_admin_cannot_access_customer_transactions(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('customer.transactions'));

        $response->assertRedirect(route('dashboard'));
    }
}
