<?php

namespace Database\Factories;

use App\Models\EventPackage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EventPackage>
 */
class EventPackageFactory extends Factory
{
    protected $model = EventPackage::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'tagline' => 'Up to '.fake()->numberBetween(20, 100).' guests',
            'price' => fake()->randomFloat(2, 50000, 250000),
            'price_label' => null,
            'price_interval' => 'event',
            'features' => [
                fake()->sentence(3),
                fake()->sentence(3),
            ],
            'is_featured' => false,
            'badge_text' => null,
            'button_text' => 'Get a Quote',
            'sort_order' => fake()->numberBetween(1, 10),
            'is_active' => true,
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (): array => [
            'is_featured' => true,
            'badge_text' => 'Most Popular',
            'button_text' => 'Book Consultation',
        ]);
    }

    public function customPricing(): static
    {
        return $this->state(fn (): array => [
            'price' => null,
            'price_label' => 'Custom',
            'button_text' => 'Contact Us',
        ]);
    }
}
