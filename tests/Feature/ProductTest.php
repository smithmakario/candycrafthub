<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\ProductOrigin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_products_index(): void
    {
        $this->get(route('products.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_products_index(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(route('products.index'))
            ->assertOk();
    }

    public function test_authenticated_user_can_create_product(): void
    {
        $user = User::factory()->admin()->create();
        $category = Category::factory()->create(['name' => 'Gummies']);

        $response = $this->actingAs($user)->post(route('products.store'), [
            'name' => 'Tangerine Chews',
            'sku' => 'CCH-1001',
            'origin' => ProductOrigin::LocalNostalgia->value,
            'category_id' => $category->id,
            'unit_price' => 150,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Tangerine Chews',
            'sku' => 'CCH-1001',
            'category_id' => $category->id,
        ]);
    }

    public function test_authenticated_user_can_create_product_with_image(): void
    {
        Storage::fake('public');
        $user = User::factory()->admin()->create();
        $category = Category::factory()->create(['name' => 'Gummies']);

        $response = $this->actingAs($user)->post(route('products.store'), [
            'name' => 'Tangerine Chews',
            'sku' => 'CCH-1002',
            'origin' => ProductOrigin::LocalNostalgia->value,
            'category_id' => $category->id,
            'unit_price' => 150,
            'is_active' => true,
            'image' => UploadedFile::fake()->image('tangerine.jpg'),
        ]);

        $response->assertRedirect(route('products.index'));

        $product = Product::query()->where('sku', 'CCH-1002')->first();
        $this->assertNotNull($product?->image_path);
        Storage::disk('public')->assertExists($product->image_path);
    }

    public function test_authenticated_user_can_update_product(): void
    {
        $user = User::factory()->admin()->create();
        $product = Product::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($user)->put(route('products.update', $product), [
            'name' => 'Updated Name',
            'sku' => $product->sku,
            'origin' => $product->origin->value,
            'category_id' => $product->category_id,
            'unit_price' => $product->unit_price,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_authenticated_user_can_delete_product(): void
    {
        $user = User::factory()->admin()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->delete(route('products.destroy', $product));

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
