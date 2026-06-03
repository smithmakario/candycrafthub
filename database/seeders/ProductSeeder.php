<?php

namespace Database\Seeders;

use App\Models\InventoryItem;
use App\Models\Product;
use App\ProductOrigin;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catalog = [
            ['name' => 'Tangerine Chews', 'origin' => ProductOrigin::LocalNostalgia, 'category' => 'Gummies', 'unit_price' => 150, 'quantity' => 1240, 'threshold' => 100],
            ['name' => 'Swiss Truffle Mix', 'origin' => ProductOrigin::InternationalImports, 'category' => 'Truffles', 'unit_price' => 1200, 'quantity' => 42, 'threshold' => 50],
            ['name' => 'Hibiscus Jelly Beans', 'origin' => ProductOrigin::LocalNostalgia, 'category' => 'Jellies', 'unit_price' => 450, 'quantity' => 800, 'threshold' => 80],
            ['name' => 'Sour Belgian Drops', 'origin' => ProductOrigin::InternationalImports, 'category' => 'Gummies', 'unit_price' => 950, 'quantity' => 210, 'threshold' => 75],
        ];

        foreach ($catalog as $item) {
            $product = Product::query()->create([
                'name' => $item['name'],
                'sku' => strtoupper(str_replace(' ', '-', $item['name'])),
                'origin' => $item['origin'],
                'category' => $item['category'],
                'unit_price' => $item['unit_price'],
                'is_active' => true,
            ]);

            InventoryItem::query()->create([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'low_stock_threshold' => $item['threshold'],
            ]);
        }
    }
}
