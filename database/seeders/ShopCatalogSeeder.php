<?php

namespace Database\Seeders;

use App\Models\InventoryItem;
use App\Models\Product;
use App\ProductOrigin;
use Illuminate\Database\Seeder;

class ShopCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catalog = [
            [
                'sku' => 'SHOP-SUGAR-CLOUDS',
                'name' => 'Sugar Clouds Box',
                'origin' => ProductOrigin::LocalNostalgia,
                'category' => 'Gummies',
                'unit_price' => 12500,
                'badge' => 'Bestseller',
                'taste_profile' => 'Zesty lime, wild berry & creamy vanilla finish.',
                'memory_quote' => 'Reminds you of laughter-filled after-school hangouts.',
                'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBBoCNdW0k4bY3iUIRquF49YMY9CPxnlpEMyyuuWpGv6K407ATQqyvtDP75aSfTOyieYeLgHxEheTeBnWKv0lrYtJ3EBYjCNeXWjDaUGZMNVbBXuqTUQpSN5Hmqp-i55XaEP3RzCwWJ2rzFj9qbuaBbon52eAR4lf-jjV9M2clymgVLzKuDhiU-_g1JiDVTuQYM6YM0MeZ3WmwqGZbMGtAJqyDR703Khx37fixmRWrxPVKP9WN29urPPsv-b1BcM2rTghWPzKZzixXI',
                'quantity' => 500,
                'threshold' => 50,
            ],
            [
                'sku' => 'SHOP-MIDNIGHT-TRUFFLES',
                'name' => 'Midnight Truffles',
                'origin' => ProductOrigin::InternationalImports,
                'category' => 'Chocolate',
                'unit_price' => 18200,
                'badge' => null,
                'taste_profile' => '70% Cocoa, sea salt, and a hint of espresso.',
                'memory_quote' => 'Like a quiet midnight rain in a cozy city study.',
                'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB_jirG2HVq2Oy5XCgPyXiUCV4W7QeRVFycVH2uITwwjY2dHRoAtmn9zUlQMyflAgUm0w5CLQn5gkmwmihUEMN3Wt916tR5Sv_b2_pT5R86E9jVLJGrRZxwWUz_A4zSjaHelIK2Jt9RaMB9xz9YZqECy8vdD_z5o8hQbN3K6HFvuh_3e8ZXoS8svxqcI_VeFXz6D36xi7xGIYFNj0xNXEU7JPCXiYH2vinGEAwTsEM1x80Zf5UfIwfFosMzEYCB0smnwVOtML9z0b34',
                'quantity' => 120,
                'threshold' => 25,
            ],
            [
                'sku' => 'SHOP-LAGOS-LEGACY',
                'name' => 'Lagos Legacy Tin',
                'origin' => ProductOrigin::LocalNostalgia,
                'category' => 'Nostalgic Classics',
                'unit_price' => 15000,
                'badge' => 'New Arrival',
                'taste_profile' => 'Toasted coconut, burnt sugar, and nostalgic spice.',
                'memory_quote' => 'The crunch of heritage from Grandma\'s secret jar.',
                'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBYZqpiGYXqIBmy5XP1PWUoV5eXRlUH-lkbtunYnhbVVHHSKrR3dVNHhH7_pZhKxv3thRqo-c4QfbUO3Fn5qFVqDJjLdNUEKxCiNgxPcRsH5lJLfHjEuVrXb3uhUxoeizm-C2jht0UTavnRAv6D9lMkRNDmHEbkPOsmF3F9Wfs-RsZqcWEZixtE3r9WfxiKBz7Cz4ZuRiDkidms1t9iTI0bNhKpqwxJ3Rub-YsAPkYzVJPdj0KZwL33OnnOMvm-3uVKGmEBgAALO2CD',
                'quantity' => 200,
                'threshold' => 40,
            ],
            [
                'sku' => 'SHOP-PASTEL-DREAMS',
                'name' => 'Pastel Dreams Jar',
                'origin' => ProductOrigin::InternationalImports,
                'category' => 'Gummies',
                'unit_price' => 9800,
                'badge' => null,
                'taste_profile' => 'Peppermint breeze and sweet marshmallow cloud.',
                'memory_quote' => 'The pure excitement of a Sunday carnival.',
                'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD_hrPRyr-ZZxefkc0EAfYZ59gojm-sp0AEm1ErWH4GNZTIntHypOURvlnaDCBTrhQ5LvGb7qFpgcGW2AX2NyKX-xhaVVTOTvR_AqJ6ybjOI4Zd5duO7v-CDyNvpdovq3iky-VJSLUv338o7GjRLSgd5ZgsTJm4vEcVGar-0ufFVFL9mEN3iRp_UZmdfw0jyVXKc2umZz0ZeI_t7qt1d_TDRCznv5E2x-gXujKc6rr4LOGE7lwmnrzGS4uATOqlvKuGfRuTs69oBBqB',
                'quantity' => 350,
                'threshold' => 45,
            ],
        ];

        foreach ($catalog as $item) {
            $product = Product::query()->updateOrCreate(
                ['sku' => $item['sku']],
                [
                    'name' => $item['name'],
                    'origin' => $item['origin'],
                    'category' => $item['category'],
                    'unit_price' => $item['unit_price'],
                    'badge' => $item['badge'],
                    'taste_profile' => $item['taste_profile'],
                    'memory_quote' => $item['memory_quote'],
                    'image_path' => $item['image_path'],
                    'is_active' => true,
                ],
            );

            InventoryItem::query()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    'quantity' => $item['quantity'],
                    'low_stock_threshold' => $item['threshold'],
                ],
            );
        }
    }
}
