<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\MembershipPlan;
use App\Models\Order;
use App\Models\User;
use Illuminate\View\View;

class CustomerDashboardController extends Controller
{
    public function index(): View
    {
        /** @var User $user */
        $user = auth()->user();

        $orders = Order::query()
            ->forCustomer($user)
            ->with('items')
            ->orderByDesc('created_at')
            ->get();

        $bookings = Booking::query()
            ->forCustomer($user)
            ->orderByDesc('event_date')
            ->orderByDesc('created_at')
            ->get();

        $membershipPlans = MembershipPlan::query()
            ->active()
            ->ordered()
            ->get();

        return view('customer.dashboard', [
            'orders' => $orders,
            'bookings' => $bookings,
            'membershipPlans' => $membershipPlans,
        ]);
    }
}
