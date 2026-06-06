<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitBankTransferPaymentRequest;
use App\Mail\OrderPaymentReceipt;
use App\Models\Order;
use App\Models\User;
use App\OrderStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::query()
            ->with('user')
            ->withSum('items as items_quantity', 'quantity')
            ->orderByDesc('created_at')
            ->paginate(15);

        $pendingApprovalCount = Order::query()->pendingApproval()->count();

        return view('orders.index', [
            'orders' => $orders,
            'pendingApprovalCount' => $pendingApprovalCount,
        ]);
    }

    public function customerIndex(): View
    {
        /** @var User $user */
        $user = auth()->user();

        $orders = Order::query()
            ->forCustomer($user)
            ->withSum('items as items_quantity', 'quantity')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('customer.transactions', [
            'orders' => $orders,
        ]);
    }

    public function submitPayment(SubmitBankTransferPaymentRequest $request, Order $order): RedirectResponse
    {
        if (! $order->isBankTransfer() || $order->status !== OrderStatus::Pending) {
            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'This order cannot accept a bank transfer confirmation.');
        }

        if ($order->hasSubmittedPayment()) {
            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'Payment has already been submitted for this order.');
        }

        $order->update([
            'bank_account_currency' => $request->validated('bank_account_currency'),
            'payment_submitted_at' => now(),
        ]);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Thank you! We have received your payment notification and will confirm once verified.');
    }

    public function confirmPayment(Order $order): RedirectResponse
    {
        if (! $order->isPendingApproval()) {
            return redirect()
                ->route('orders.index')
                ->with('error', 'This order cannot be confirmed.');
        }

        $order->update([
            'status' => OrderStatus::Paid,
            'paid_at' => now(),
        ]);

        Mail::to($order->email)->send(new OrderPaymentReceipt($order));

        return redirect()
            ->route('orders.index')
            ->with('success', "Payment confirmed for order #{$order->reference}. A receipt was sent to {$order->email}.");
    }
}
