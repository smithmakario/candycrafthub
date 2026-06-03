<?php

namespace Database\Factories;

use App\Models\InventoryItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InventoryItem>
 */
class InventoryItemFactory extends Factory
{
    protected $model = InventoryItem::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'quantity' => fake()->numberBetween(10, 1500),
            'low_stock_threshold' => fake()->numberBetween(30, 100),
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function lowStock(): static
    {
        return $this->state(function (): array {
            $threshold = fake()->numberBetween(50, 100);

            return [
                'low_stock_threshold' => $threshold,
                'quantity' => fake()->numberBetween(1, $threshold),
            ];
        });
    }
}
