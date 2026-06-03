<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cart,
    ) {}

    public function index(): View
    {
        return view('cart.index', [
            'lines' => $this->cart->lines(),
            'subtotal' => $this->cart->subtotal(),
        ]);
    }

    public function store(StoreCartItemRequest $request, Product $product): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        $this->cart->add($product, $request->integer('quantity', 1));

        return redirect()
            ->back()
            ->with('success', "{$product->name} added to your cart.");
    }

    public function update(UpdateCartItemRequest $request, Product $product): RedirectResponse
    {
        $this->cart->update($product, $request->integer('quantity'));

        return redirect()
            ->route('cart.index')
            ->with('success', 'Cart updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->cart->remove($product);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Item removed from cart.');
    }
}
