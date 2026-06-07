<?php

namespace App\Http\Controllers;

use App\BookingStatus;
use App\Models\Booking;
use App\Models\Category;
use App\Models\InventoryItem;
use App\Models\Product;
use App\ProductOrigin;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $activeBookingsCount = Booking::query()->active()->count();
        $newInquiriesCount = Booking::query()->status(BookingStatus::InquiryReceived)->count();
        $lowStockCount = InventoryItem::query()->lowStock()->count();

        $topCategory = Category::query()
            ->withCount('products')
            ->orderByDesc('products_count')
            ->value('name') ?? 'Gourmet Gummies';

        $inventoryItems = InventoryItem::query()
            ->with('product')
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        $bookingsByStatus = collect(BookingStatus::pipelineOrder())
            ->mapWithKeys(fn (BookingStatus $status): array => [
                $status->value => Booking::query()
                    ->status($status)
                    ->orderByDesc('event_date')
                    ->limit(5)
                    ->get(),
            ]);

        return view('dashboard', [
            'productCount' => Product::query()->count(),
            'activeBookingsCount' => $activeBookingsCount,
            'newInquiriesCount' => $newInquiriesCount,
            'lowStockCount' => $lowStockCount,
            'topCategory' => $topCategory,
            'inventoryItems' => $inventoryItems,
            'bookingsByStatus' => $bookingsByStatus,
            'statuses' => BookingStatus::pipelineOrder(),
            'origins' => ProductOrigin::cases(),
        ]);
    }
}
