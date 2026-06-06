<?php

namespace Tests\Feature;

use App\Mail\OrderPaymentReceipt;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\OrderStatus;
use App\PaymentMethod;
use App\Services\CartService;
use Database\Seeders\ShopCatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CheckoutPaymentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ShopCatalogSeeder::class);
    }

    public function test_checkout_with_bank_transfer_creates_order_and_shows_bank_details(): void
    {
        $product = Product::query()->where('sku', 'SHOP-SUGAR-CLOUDS')->firstOrFail();
        app(CartService::class)->add($product, 1);

        $response = $this->post(route('checkout.store'), [
            'account_mode' => 'register',
            'first_name' => 'Shop',
            'last_name' => 'Customer',
            'email' => 'shopper@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'fulfillment_type' => 'pickup',
            'payment_method' => 'bank_transfer',
        ]);

        $order = Order::query()->where('email', 'shopper@example.com')->firstOrFail();

        $response->assertRedirect(route('orders.show', $order));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'payment_method' => PaymentMethod::BankTransfer->value,
            'status' => OrderStatus::Pending->value,
        ]);

        $this->assertTrue(app(CartService::class)->isEmpty());

        $this->get(route('orders.show', $order))
            ->assertOk()
            ->assertSee('Bank transfer details')
            ->assertSee('1309749995')
            ->assertSee('1309755640')
            ->assertSee('1309755664')
            ->assertSee('Providus Bank')
            ->assertSee('Candy Craft Hub')
            ->assertSee($order->reference)
            ->assertSee('I made payment to the above account');
    }

    public function test_customer_can_submit_bank_transfer_payment_with_selected_account(): void
    {
        $order = Order::query()->create([
            'email' => 'shopper@example.com',
            'fulfillment_type' => 'pickup',
            'reference' => 'CCH_SUBMIT_ME',
            'payment_method' => PaymentMethod::BankTransfer,
            'status' => OrderStatus::Pending,
            'total_amount' => 12500,
            'currency' => 'NGN',
        ]);

        $this->post(route('orders.submit-payment', $order), [
            'bank_account_currency' => 'USD',
        ])
            ->assertRedirect(route('orders.show', $order))
            ->assertSessionHas('success');

        $order->refresh();

        $this->assertSame('USD', $order->bank_account_currency);
        $this->assertNotNull($order->payment_submitted_at);
        $this->assertTrue($order->isPendingApproval());

        $this->get(route('orders.show', $order))
            ->assertOk()
            ->assertSee('Pending approval')
            ->assertSee('1309755640')
            ->assertDontSee('I made payment to the above account');
    }

    public function test_customer_cannot_submit_payment_twice(): void
    {
        $order = Order::query()->create([
            'email' => 'shopper@example.com',
            'fulfillment_type' => 'pickup',
            'reference' => 'CCH_ALREADY_SUBMITTED',
            'payment_method' => PaymentMethod::BankTransfer,
            'bank_account_currency' => 'NGN',
            'status' => OrderStatus::Pending,
            'total_amount' => 12500,
            'currency' => 'NGN',
            'payment_submitted_at' => now(),
        ]);

        $this->post(route('orders.submit-payment', $order), [
            'bank_account_currency' => 'GBP',
        ])
            ->assertRedirect(route('orders.show', $order))
            ->assertSessionHas('error');

        $this->assertSame('NGN', $order->fresh()->bank_account_currency);
    }

    public function test_paystack_initiate_is_blocked_for_bank_transfer_orders(): void
    {
        $order = Order::query()->create([
            'email' => 'shopper@example.com',
            'fulfillment_type' => 'pickup',
            'reference' => 'CCH_BANK_TRANSFER',
            'payment_method' => PaymentMethod::BankTransfer,
            'status' => OrderStatus::Pending,
            'total_amount' => 12500,
            'currency' => 'NGN',
        ]);

        $this->get(route('payment.initiate', $order))
            ->assertRedirect(route('orders.show', $order))
            ->assertSessionHas('error');
    }

    public function test_admin_can_approve_submitted_bank_transfer_and_send_receipt(): void
    {
        Mail::fake();

        $admin = User::factory()->admin()->create();

        $order = Order::query()->create([
            'email' => 'shopper@example.com',
            'fulfillment_type' => 'pickup',
            'reference' => 'CCH_CONFIRM_ME',
            'payment_method' => PaymentMethod::BankTransfer,
            'bank_account_currency' => 'NGN',
            'status' => OrderStatus::Pending,
            'total_amount' => 12500,
            'currency' => 'NGN',
            'payment_submitted_at' => now()->subHour(),
        ]);

        $this->actingAs($admin)
            ->post(route('orders.confirm-payment', $order))
            ->assertRedirect(route('orders.index'))
            ->assertSessionHas('success');

        $order->refresh();

        $this->assertTrue($order->isPaid());
        $this->assertNotNull($order->paid_at);

        Mail::assertSent(OrderPaymentReceipt::class, function (OrderPaymentReceipt $mail) use ($order): bool {
            return $mail->hasTo($order->email)
                && $mail->order->is($order);
        });

        $this->get(route('orders.show', $order))
            ->assertOk()
            ->assertSee('Payment receipt')
            ->assertSee('A copy of this receipt was sent to shopper@example.com');
    }

    public function test_admin_cannot_confirm_bank_transfer_without_customer_submission(): void
    {
        $admin = User::factory()->admin()->create();

        $order = Order::query()->create([
            'email' => 'shopper@example.com',
            'fulfillment_type' => 'pickup',
            'reference' => 'CCH_NOT_SUBMITTED',
            'payment_method' => PaymentMethod::BankTransfer,
            'status' => OrderStatus::Pending,
            'total_amount' => 12500,
            'currency' => 'NGN',
        ]);

        $this->actingAs($admin)
            ->post(route('orders.confirm-payment', $order))
            ->assertRedirect(route('orders.index'))
            ->assertSessionHas('error');

        $this->assertFalse($order->fresh()->isPaid());
    }

    public function test_admin_cannot_confirm_paystack_pending_order(): void
    {
        $admin = User::factory()->admin()->create();

        $order = Order::query()->create([
            'email' => 'shopper@example.com',
            'fulfillment_type' => 'pickup',
            'reference' => 'CCH_PAYSTACK_PENDING',
            'payment_method' => PaymentMethod::Paystack,
            'status' => OrderStatus::Pending,
            'total_amount' => 12500,
            'currency' => 'NGN',
        ]);

        $this->actingAs($admin)
            ->post(route('orders.confirm-payment', $order))
            ->assertRedirect(route('orders.index'))
            ->assertSessionHas('error');

        $this->assertFalse($order->fresh()->isPaid());
    }

    public function test_admin_transactions_page_highlights_pending_approval_orders(): void
    {
        $admin = User::factory()->admin()->create();

        $order = Order::query()->create([
            'email' => 'shopper@example.com',
            'fulfillment_type' => 'pickup',
            'reference' => 'CCH_PENDING_APPROVAL',
            'payment_method' => PaymentMethod::BankTransfer,
            'bank_account_currency' => 'GBP',
            'status' => OrderStatus::Pending,
            'total_amount' => 12500,
            'currency' => 'NGN',
            'payment_submitted_at' => now(),
        ]);

        $this->actingAs($admin)
            ->get(route('orders.index'))
            ->assertOk()
            ->assertSee('1 bank transfer payment is awaiting your approval')
            ->assertSee($order->reference)
            ->assertSee('Pending approval')
            ->assertSee('GBP (1309755664)')
            ->assertSee('Approve');
    }
}
