<?php

namespace Database\Seeders;

use App\Models\MembershipPlan;
use Illuminate\Database\Seeder;

class MembershipPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'The Taster',
                'tagline' => 'Perfect for light snacking',
                'price' => 12500,
                'billing_interval' => 'mo',
                'features' => [
                    '5 Premium treats',
                    'Curated flavor profile',
                ],
                'is_featured' => false,
                'badge_text' => null,
                'button_text' => 'Select Plan',
                'sort_order' => 1,
            ],
            [
                'name' => 'The Explorer',
                'tagline' => 'The quintessential candy journey',
                'price' => 22000,
                'billing_interval' => 'mo',
                'features' => [
                    '10 Handpicked treats',
                    'Exclusive vinyl stickers',
                    'First access to new arrivals',
                ],
                'is_featured' => true,
                'badge_text' => 'Most Popular',
                'button_text' => 'Subscribe Now',
                'sort_order' => 2,
            ],
            [
                'name' => 'The Connoisseur',
                'tagline' => 'For the ultimate sweet tooth',
                'price' => 35000,
                'billing_interval' => 'mo',
                'features' => [
                    '15 Premium treats',
                    'Limited edition merch',
                    'VIP Lagos delivery (Priority)',
                ],
                'is_featured' => false,
                'badge_text' => null,
                'button_text' => 'Select Plan',
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $plan) {
            MembershipPlan::query()->create($plan);
        }
    }
}
