<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(Request $request): View
    {
        $categorySlug = $request->string('category')->toString();

        $categories = Category::query()
            ->active()
            ->ordered()
            ->get();

        $activeCategory = $categorySlug !== ''
            ? $categories->firstWhere('slug', $categorySlug)
            : null;

        $products = Product::query()
            ->active()
            ->with('category')
            ->where('sku', 'like', 'SHOP-%')
            ->when($activeCategory, fn ($query) => $query->whereBelongsTo($activeCategory))
            ->orderBy('name')
            ->get();

        return view('shop.index', [
            'products' => $products,
            'categories' => $categories,
            'activeCategory' => $activeCategory,
        ]);
    }
}
