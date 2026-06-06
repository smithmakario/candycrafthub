<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\OrderStatus;
use App\PaymentMethod;
use App\Services\CartService;
use App\UserType;
use Database\Seeders\ShopCatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ShopCatalogSeeder::class);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function registrationPayload(array $overrides = []): array
    {
        return array_merge([
            'account_mode' => 'register',
            'first_name' => 'Shop',
            'last_name' => 'Customer',
            'email' => 'shopper@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'fulfillment_type' => 'pickup',
            'payment_method' => 'paystack',
        ], $overrides);
    }

    public function test_guest_can_register_during_checkout_and_order_is_linked_to_account(): void
    {
        $product = Product::query()->where('sku', 'SHOP-SUGAR-CLOUDS')->firstOrFail();
        app(CartService::class)->add($product, 1);

        $response = $this->post(route('checkout.store'), $this->registrationPayload());

        $user = User::query()->where('email', 'shopper@example.com')->firstOrFail();
        $order = Order::query()->where('email', 'shopper@example.com')->firstOrFail();

        $response->assertRedirect(route('payment.initiate', $order));

        $this->assertAuthenticatedAs($user);
        $this->assertSame($user->id, $order->user_id);
        $this->assertSame(UserType::Customer, $user->user_type);

        $this->assertDatabaseHas('users', [
            'email' => 'shopper@example.com',
            'first_name' => 'Shop',
            'last_name' => 'Customer',
        ]);
    }

    public function test_guest_can_sign_in_during_checkout(): void
    {
        $user = User::factory()->customer()->create([
            'email' => 'returning@example.com',
        ]);

        $product = Product::query()->where('sku', 'SHOP-SUGAR-CLOUDS')->firstOrFail();
        app(CartService::class)->add($product, 1);

        $response = $this->post(route('checkout.store'), [
            'account_mode' => 'login',
            'email' => 'returning@example.com',
            'password' => 'password',
            'fulfillment_type' => 'pickup',
            'payment_method' => 'paystack',
        ]);

        $order = Order::query()->where('user_id', $user->id)->firstOrFail();

        $response->assertRedirect(route('payment.initiate', $order));
        $this->assertAuthenticatedAs($user);
        $this->assertSame($user->id, $order->user_id);
    }

    public function test_logged_in_customer_can_checkout_without_account_fields(): void
    {
        $user = User::factory()->customer()->create();
        $product = Product::query()->where('sku', 'SHOP-SUGAR-CLOUDS')->firstOrFail();
        app(CartService::class)->add($product, 1);

        $response = $this->actingAs($user)->post(route('checkout.store'), [
            'fulfillment_type' => 'pickup',
            'payment_method' => 'paystack',
        ]);

        $order = Order::query()->where('user_id', $user->id)->firstOrFail();

        $response->assertRedirect(route('payment.initiate', $order));
        $this->assertSame($user->email, $order->email);
    }

    public function test_checkout_registration_requires_unique_email(): void
    {
        User::factory()->customer()->create(['email' => 'shopper@example.com']);

        $product = Product::query()->where('sku', 'SHOP-SUGAR-CLOUDS')->firstOrFail();
        app(CartService::class)->add($product, 1);

        $this->post(route('checkout.store'), $this->registrationPayload())
            ->assertSessionHasErrors('email');
    }

    public function test_checkout_registration_requires_phone_for_delivery(): void
    {
        $product = Product::query()->where('sku', 'SHOP-SUGAR-CLOUDS')->firstOrFail();
        app(CartService::class)->add($product, 1);

        $this->post(route('checkout.store'), $this->registrationPayload([
            'fulfillment_type' => 'delivery',
            'delivery_address' => '12 Admiralty Way, Lekki Phase 1, Lagos',
            'phone' => '',
        ]))->assertSessionHasErrors('phone');

        $this->post(route('checkout.store'), $this->registrationPayload([
            'email' => 'delivery@example.com',
            'fulfillment_type' => 'delivery',
            'delivery_address' => '12 Admiralty Way, Lekki Phase 1, Lagos',
            'phone' => '08012345678',
            'payment_method' => 'bank_transfer',
        ]))->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'email' => 'delivery@example.com',
            'fulfillment_type' => 'delivery',
            'payment_method' => PaymentMethod::BankTransfer->value,
            'status' => OrderStatus::Pending->value,
        ]);
    }

    public function test_checkout_page_shows_account_section_for_guests(): void
    {
        $product = Product::query()->where('sku', 'SHOP-SUGAR-CLOUDS')->firstOrFail();
        app(CartService::class)->add($product, 1);

        $this->get(route('checkout.create'))
            ->assertOk()
            ->assertSee('Create account')
            ->assertSee('Sign in');
    }
}
