<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInventoryItemRequest;
use App\Http\Requests\UpdateInventoryItemRequest;
use App\Models\InventoryItem;
use App\Models\Product;
use App\ProductOrigin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryItemController extends Controller
{
    public function index(Request $request): View
    {
        $originFilter = $request->query('origin');
        $origin = $originFilter ? ProductOrigin::tryFrom($originFilter) : null;

        $inventoryItems = InventoryItem::query()
            ->with('product')
            ->when($origin, function ($query) use ($origin): void {
                $query->whereHas('product', fn ($productQuery) => $productQuery->where('origin', $origin));
            })
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('inventory.index', [
            'inventoryItems' => $inventoryItems,
            'origins' => ProductOrigin::cases(),
            'activeOrigin' => $origin,
        ]);
    }

    public function create(): View
    {
        $productsWithoutInventory = Product::query()
            ->whereDoesntHave('inventoryItem')
            ->orderBy('name')
            ->get();

        return view('inventory.create', [
            'products' => $productsWithoutInventory,
        ]);
    }

    public function store(StoreInventoryItemRequest $request): RedirectResponse
    {
        InventoryItem::query()->create($request->validated());

        return redirect()
            ->route('inventory.index')
            ->with('success', 'Inventory record created successfully.');
    }

    public function show(InventoryItem $inventoryItem): View
    {
        $inventoryItem->load('product');

        return view('inventory.show', [
            'inventoryItem' => $inventoryItem,
        ]);
    }

    public function edit(InventoryItem $inventoryItem): View
    {
        $inventoryItem->load('product');

        return view('inventory.edit', [
            'inventoryItem' => $inventoryItem,
        ]);
    }

    public function update(UpdateInventoryItemRequest $request, InventoryItem $inventoryItem): RedirectResponse
    {
        $inventoryItem->update($request->validated());

        return redirect()
            ->route('inventory.index')
            ->with('success', 'Inventory updated successfully.');
    }

    public function destroy(InventoryItem $inventoryItem): RedirectResponse
    {
        $inventoryItem->delete();

        return redirect()
            ->route('inventory.index')
            ->with('success', 'Inventory record deleted successfully.');
    }
}
