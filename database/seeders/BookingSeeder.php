<?php

namespace Database\Seeders;

use App\BookingStatus;
use App\EventType;
use App\Models\Booking;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookings = [
            ['title' => 'The Adelaja Nuptials', 'event_type' => EventType::Wedding, 'status' => BookingStatus::InquiryReceived, 'event_date' => '2026-10-24'],
            ['title' => 'Zenith Bank Gala', 'event_type' => EventType::Corporate, 'status' => BookingStatus::InquiryReceived, 'event_date' => '2026-11-02'],
            ['title' => "Chioma's 10th Bash", 'event_type' => EventType::Birthday, 'status' => BookingStatus::Planning, 'event_date' => '2026-10-30'],
            ['title' => 'Lekki Yacht Party Favors', 'event_type' => EventType::LuxuryGift, 'status' => BookingStatus::InProduction, 'event_date' => '2026-11-15', 'progress' => 75, 'is_priority' => true],
            ['title' => "Prof. Ibrahim's Sendforth", 'event_type' => EventType::Retirement, 'status' => BookingStatus::Completed, 'event_date' => '2026-09-12', 'progress' => 100],
        ];

        foreach ($bookings as $booking) {
            Booking::query()->create([
                ...$booking,
                'guest_count' => fake()->numberBetween(50, 250),
                'customer_name' => fake()->name(),
                'customer_email' => fake()->safeEmail(),
            ]);
        }
    }
}
