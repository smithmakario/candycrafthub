<?php

namespace Tests\Feature;

use App\Models\Product;
use App\ProductOrigin;
use Database\Seeders\ShopCatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ShopCatalogSeeder::class);
    }

    public function test_shop_page_is_accessible(): void
    {
        $this->get(route('shop'))
            ->assertOk()
            ->assertViewIs('shop.index')
            ->assertSee('Sugar Clouds Box')
            ->assertSee('Midnight Truffles');
    }

    public function test_shop_page_can_filter_by_category(): void
    {
        $this->get(route('shop', ['filter' => 'chocolate']))
            ->assertOk()
            ->assertSee('Midnight Truffles')
            ->assertDontSee('Sugar Clouds Box');
    }

    public function test_guest_can_add_product_to_cart(): void
    {
        $product = Product::query()->where('sku', 'SHOP-SUGAR-CLOUDS')->firstOrFail();

        $this->post(route('cart.store', $product), ['quantity' => 2])
            ->assertRedirect();

        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee('Sugar Clouds Box')
            ->assertSee('₦25,000');
    }

    public function test_guest_can_checkout_and_create_pending_order(): void
    {
        $product = Product::query()->where('sku', 'SHOP-SUGAR-CLOUDS')->firstOrFail();

        $this->post(route('cart.store', $product));

        $response = $this->post(route('checkout.store'), [
            'email' => 'shopper@example.com',
            'fulfillment_type' => 'pickup',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'email' => 'shopper@example.com',
            'fulfillment_type' => 'pickup',
            'delivery_address' => null,
            'status' => 'pending',
            'total_amount' => 12500,
        ]);
    }

    public function test_checkout_requires_address_for_delivery(): void
    {
        $product = Product::query()->where('sku', 'SHOP-SUGAR-CLOUDS')->firstOrFail();

        $this->post(route('cart.store', $product));

        $this->post(route('checkout.store'), [
            'email' => 'shopper@example.com',
            'fulfillment_type' => 'delivery',
        ])->assertSessionHasErrors('delivery_address');

        $this->post(route('checkout.store'), [
            'email' => 'shopper@example.com',
            'fulfillment_type' => 'delivery',
            'delivery_address' => '12 Admiralty Way, Lekki Phase 1, Lagos',
        ])->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'email' => 'shopper@example.com',
            'fulfillment_type' => 'delivery',
            'delivery_address' => '12 Admiralty Way, Lekki Phase 1, Lagos',
        ]);
    }

    public function test_shop_only_lists_catalog_products(): void
    {
        Product::factory()->create([
            'sku' => 'INTERNAL-ONLY',
            'name' => 'Internal Only Product',
            'origin' => ProductOrigin::LocalNostalgia,
        ]);

        $this->get(route('shop'))
            ->assertOk()
            ->assertDontSee('Internal Only Product');
    }
}
