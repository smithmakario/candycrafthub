<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Gummies', 'sort_order' => 1],
            ['name' => 'Chocolate', 'sort_order' => 2],
            ['name' => 'Jellies', 'sort_order' => 3],
            ['name' => 'Truffles', 'sort_order' => 4],
            ['name' => 'Nostalgic Classics', 'sort_order' => 5],
            ['name' => 'Chocolates', 'sort_order' => 6],
            ['name' => 'Lollipops', 'sort_order' => 7],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(
                ['slug' => Category::slugFromName($category['name'])],
                [
                    'name' => $category['name'],
                    'sort_order' => $category['sort_order'],
                    'is_active' => true,
                ],
            );
        }
    }
}
