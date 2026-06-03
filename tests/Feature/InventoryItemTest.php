<?php

namespace Tests\Feature;

use App\Models\InventoryItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_inventory_index(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('inventory.index'))
            ->assertOk();
    }

    public function test_authenticated_user_can_create_inventory_item(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post(route('inventory.store'), [
            'product_id' => $product->id,
            'quantity' => 500,
            'low_stock_threshold' => 50,
        ]);

        $response->assertRedirect(route('inventory.index'));
        $this->assertDatabaseHas('inventory_items', [
            'product_id' => $product->id,
            'quantity' => 500,
        ]);
    }

    public function test_authenticated_user_can_update_inventory_item(): void
    {
        $user = User::factory()->create();
        $inventoryItem = InventoryItem::factory()->create(['quantity' => 100]);

        $response = $this->actingAs($user)->put(route('inventory.update', $inventoryItem), [
            'quantity' => 250,
            'low_stock_threshold' => $inventoryItem->low_stock_threshold,
        ]);

        $response->assertRedirect(route('inventory.index'));
        $this->assertDatabaseHas('inventory_items', [
            'id' => $inventoryItem->id,
            'quantity' => 250,
        ]);
    }

    public function test_authenticated_user_can_delete_inventory_item(): void
    {
        $user = User::factory()->create();
        $inventoryItem = InventoryItem::factory()->create();

        $response = $this->actingAs($user)->delete(route('inventory.destroy', $inventoryItem));

        $response->assertRedirect(route('inventory.index'));
        $this->assertDatabaseMissing('inventory_items', ['id' => $inventoryItem->id]);
    }
}
