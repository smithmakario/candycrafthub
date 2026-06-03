<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\ProductOrigin;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    /**
     * @var array<string, array{label: string, origin?: ProductOrigin, category?: string}>
     */
    private const array Filters = [
        'nostalgic' => [
            'label' => 'Nostalgic Classics',
            'origin' => ProductOrigin::LocalNostalgia,
        ],
        'global' => [
            'label' => 'Global Discoveries',
            'origin' => ProductOrigin::InternationalImports,
        ],
        'gummies' => [
            'label' => 'Gummies & Chews',
            'category' => 'Gummies',
        ],
        'chocolate' => [
            'label' => 'Chocolate Lovers',
            'category' => 'Chocolate',
        ],
    ];

    public function index(Request $request): View
    {
        $activeFilter = $request->string('filter')->toString();
        $filterKey = array_key_exists($activeFilter, self::Filters) ? $activeFilter : null;

        $products = Product::query()
            ->active()
            ->where('sku', 'like', 'SHOP-%')
            ->when($filterKey, function ($query) use ($filterKey): void {
                $filter = self::Filters[$filterKey];

                if (isset($filter['origin'])) {
                    $query->where('origin', $filter['origin']);
                }

                if (isset($filter['category'])) {
                    $query->where('category', $filter['category']);
                }
            })
            ->orderBy('name')
            ->get();

        return view('shop.index', [
            'products' => $products,
            'filters' => self::Filters,
            'activeFilter' => $filterKey,
        ]);
    }
}
