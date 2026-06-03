<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\OrderStatus;
use App\Services\CartService;
use Database\Seeders\ShopCatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PaymentCallbackTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ShopCatalogSeeder::class);

        config([
            'paystack.secretKey' => 'sk_test_example',
            'paystack.paymentUrl' => 'https://api.paystack.co',
        ]);
    }

    public function test_successful_callback_marks_order_paid_and_clears_cart(): void
    {
        $product = Product::query()->where('sku', 'SHOP-SUGAR-CLOUDS')->firstOrFail();
        app(CartService::class)->add($product, 1);

        $order = Order::query()->create([
            'email' => 'shopper@example.com',
            'fulfillment_type' => 'pickup',
            'reference' => 'CCH_TESTREF123456',
            'status' => OrderStatus::Pending,
            'total_amount' => 12500,
            'currency' => 'NGN',
        ]);

        Http::fake([
            'api.paystack.co/transaction/verify/*' => Http::response([
                'status' => true,
                'data' => [
                    'status' => 'success',
                    'amount' => 1250000,
                    'reference' => 'CCH_TESTREF123456',
                ],
            ]),
        ]);

        $this->get(route('payment.callback', ['reference' => $order->reference]))
            ->assertRedirect(route('orders.show', $order))
            ->assertSessionHas('success');

        $order->refresh();

        $this->assertTrue($order->isPaid());
        $this->assertNotNull($order->paid_at);
        $this->assertTrue(app(CartService::class)->isEmpty());
    }
}
