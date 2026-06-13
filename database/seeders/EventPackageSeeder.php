<?php

namespace Database\Seeders;

use App\Models\EventPackage;
use Illuminate\Database\Seeder;

class EventPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Sweet Social',
                'tagline' => 'Up to 30 guests',
                'price' => 85000,
                'price_interval' => 'event',
                'features' => [
                    'Curated candy display',
                    'Setup & breakdown',
                ],
                'is_featured' => false,
                'badge_text' => null,
                'button_text' => 'Get a Quote',
                'sort_order' => 1,
            ],
            [
                'name' => 'Celebration Studio',
                'tagline' => 'Up to 80 guests',
                'price' => 185000,
                'price_interval' => 'event',
                'features' => [
                    'Full candy buffet + signage',
                    'Custom color theme',
                    '2-hour on-site attendant',
                ],
                'is_featured' => true,
                'badge_text' => 'Most Popular',
                'button_text' => 'Book Consultation',
                'sort_order' => 2,
            ],
            [
                'name' => 'Grand Gala',
                'tagline' => '100+ guests',
                'price' => null,
                'price_label' => 'Custom',
                'price_interval' => 'event',
                'features' => [
                    'Multi-station dessert lounge',
                    'Branded packaging & favors',
                    'Dedicated event coordinator',
                ],
                'is_featured' => false,
                'badge_text' => null,
                'button_text' => 'Contact Us',
                'sort_order' => 3,
            ],
        ];

        foreach ($packages as $package) {
            EventPackage::query()->create($package);
        }
    }
}
