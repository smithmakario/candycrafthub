<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_categories_admin(): void
    {
        $this->get(route('categories.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_view_categories_index(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get(route('categories.index'))
            ->assertOk();
    }

    public function test_authenticated_admin_can_create_category(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->actingAs($user)->post(route('categories.store'), [
            'name' => 'Gummies',
            'slug' => 'gummies',
            'description' => 'Chewy fruit treats.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', [
            'name' => 'Gummies',
            'slug' => 'gummies',
        ]);
    }

    public function test_authenticated_admin_can_update_category(): void
    {
        $user = User::factory()->admin()->create();
        $category = Category::factory()->create(['name' => 'Old Category']);

        $response = $this->actingAs($user)->put(route('categories.update', $category), [
            'name' => 'Updated Category',
            'slug' => 'updated-category',
            'description' => 'Updated description.',
            'sort_order' => 2,
            'is_active' => false,
        ]);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated Category',
            'slug' => 'updated-category',
            'is_active' => false,
        ]);
    }

    public function test_authenticated_admin_can_delete_empty_category(): void
    {
        $user = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_category_slug_must_be_unique(): void
    {
        $user = User::factory()->admin()->create();
        Category::factory()->create(['slug' => 'gummies']);

        $response = $this->actingAs($user)->post(route('categories.store'), [
            'name' => 'Another Gummies',
            'slug' => 'gummies',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response->assertSessionHasErrors('slug');
    }

    public function test_authenticated_admin_cannot_delete_category_with_products(): void
    {
        $user = User::factory()->admin()->create();
        $category = Category::factory()->create();
        Product::factory()->create(['category_id' => $category->id]);

        $response = $this->actingAs($user)->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }
}
