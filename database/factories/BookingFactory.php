<?php

namespace Database\Factories;

use App\BookingStatus;
use App\EventType;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'event_type' => fake()->randomElement(EventType::cases()),
            'status' => fake()->randomElement(BookingStatus::cases()),
            'event_date' => fake()->dateTimeBetween('now', '+6 months'),
            'guest_count' => fake()->numberBetween(20, 300),
            'theme_color' => fake()->optional()->hexColor(),
            'customer_name' => fake()->name(),
            'customer_email' => fake()->safeEmail(),
            'customer_phone' => fake()->optional()->phoneNumber(),
            'notes' => fake()->optional()->sentence(),
            'progress' => fake()->numberBetween(0, 100),
            'is_priority' => false,
        ];
    }

    public function status(BookingStatus $status): static
    {
        return $this->state(fn (): array => [
            'status' => $status,
            'progress' => $status === BookingStatus::InProduction ? fake()->numberBetween(40, 95) : 0,
            'is_priority' => $status === BookingStatus::InProduction && fake()->boolean(30),
        ]);
    }
}
