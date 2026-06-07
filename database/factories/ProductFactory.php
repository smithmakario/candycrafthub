<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\ProductOrigin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'sku' => strtoupper(fake()->unique()->bothify('CCH-####')),
            'description' => fake()->optional()->sentence(),
            'origin' => fake()->randomElement(ProductOrigin::cases()),
            'category_id' => Category::factory(),
            'unit_price' => fake()->randomFloat(2, 100, 2500),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (): array => [
            'is_active' => false,
        ]);
    }
}
