<?php

namespace Database\Factories;

use App\Models\MembershipPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MembershipPlan>
 */
class MembershipPlanFactory extends Factory
{
    protected $model = MembershipPlan::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'tagline' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 5000, 40000),
            'billing_interval' => 'mo',
            'features' => [
                fake()->sentence(3),
                fake()->sentence(3),
            ],
            'is_featured' => false,
            'badge_text' => null,
            'button_text' => 'Select Plan',
            'sort_order' => fake()->numberBetween(1, 10),
            'is_active' => true,
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (): array => [
            'is_featured' => true,
            'badge_text' => 'Most Popular',
            'button_text' => 'Subscribe Now',
        ]);
    }
}
