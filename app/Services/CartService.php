<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class CartService
{
    private const string SessionKey = 'cart';

    /**
     * @return array<int, int> product_id => quantity
     */
    public function items(): array
    {
        /** @var array<int, int>|null $cart */
        $cart = session(self::SessionKey);

        if (! is_array($cart)) {
            return [];
        }

        $normalized = [];

        foreach ($cart as $productId => $quantity) {
            $id = (int) $productId;
            $qty = (int) $quantity;

            if ($id > 0 && $qty > 0) {
                $normalized[$id] = $qty;
            }
        }

        return $normalized;
    }

    public function add(Product $product, int $quantity = 1): void
    {
        $cart = $this->items();
        $cart[$product->id] = ($cart[$product->id] ?? 0) + max(1, $quantity);
        session([self::SessionKey => $cart]);
    }

    public function update(Product $product, int $quantity): void
    {
        $cart = $this->items();

        if ($quantity <= 0) {
            unset($cart[$product->id]);
        } else {
            $cart[$product->id] = $quantity;
        }

        session([self::SessionKey => $cart]);
    }

    public function remove(Product $product): void
    {
        $cart = $this->items();
        unset($cart[$product->id]);
        session([self::SessionKey => $cart]);
    }

    public function clear(): void
    {
        session()->forget(self::SessionKey);
    }

    public function itemCount(): int
    {
        return array_sum($this->items());
    }

    /**
     * @return Collection<int, array{product: Product, quantity: int, line_total: float}>
     */
    public function lines(): Collection
    {
        $productIds = array_keys($this->items());

        if ($productIds === []) {
            return collect();
        }

        $products = Product::query()
            ->active()
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        return collect($this->items())
            ->map(function (int $quantity, int $productId) use ($products): ?array {
                $product = $products->get($productId);

                if ($product === null) {
                    return null;
                }

                return [
                    'product' => $product,
                    'quantity' => $quantity,
                    'line_total' => (float) $product->unit_price * $quantity,
                ];
            })
            ->filter()
            ->values();
    }

    public function subtotal(): float
    {
        return (float) $this->lines()->sum('line_total');
    }

    public function isEmpty(): bool
    {
        return $this->lines()->isEmpty();
    }
}
