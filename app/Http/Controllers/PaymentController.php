<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\OrderStatus;
use App\Services\CartService;
use App\Services\PaystackService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class PaymentController extends Controller
{
    public function __construct(
        private readonly PaystackService $paystack,
        private readonly CartService $cart,
    ) {}

    public function initiate(Order $order): RedirectResponse
    {
        if ($order->status !== OrderStatus::Pending) {
            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'This order has already been processed.');
        }

        if ($order->isBankTransfer()) {
            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'This order is awaiting bank transfer. Use the account details on your order page.');
        }

        try {
            $payment = $this->paystack->initializeTransaction([
                'email' => $order->email,
                'amount' => $order->amountInKobo(),
                'reference' => $order->reference,
                'callback_url' => route('payment.callback'),
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ]);
        } catch (RuntimeException $exception) {
            return redirect()
                ->route('checkout.create')
                ->with('error', $exception->getMessage());
        }

        $authorizationUrl = $payment['authorization_url'] ?? null;

        if (! is_string($authorizationUrl) || $authorizationUrl === '') {
            return redirect()
                ->route('checkout.create')
                ->with('error', 'Unable to start payment. Please try again.');
        }

        return redirect()->away($authorizationUrl);
    }

    public function callback(Request $request): RedirectResponse
    {
        $reference = $request->string('reference')->toString();

        if ($reference === '') {
            return redirect()
                ->route('shop')
                ->with('error', 'Payment reference was not provided.');
        }

        $order = Order::query()->where('reference', $reference)->first();

        if ($order === null) {
            return redirect()
                ->route('shop')
                ->with('error', 'Order not found for this payment.');
        }

        if ($order->isPaid()) {
            return redirect()
                ->route('orders.show', $order)
                ->with('success', 'Payment already confirmed.');
        }

        try {
            $paymentData = $this->paystack->verifyTransaction($reference);
        } catch (RuntimeException $exception) {
            $order->update(['status' => OrderStatus::Failed]);

            return redirect()
                ->route('orders.show', $order)
                ->with('error', $exception->getMessage());
        }

        $status = $paymentData['status'] ?? null;
        $amountPaid = (int) ($paymentData['amount'] ?? 0);

        if ($status !== 'success' || $amountPaid < $order->amountInKobo()) {
            $order->update([
                'status' => OrderStatus::Failed,
                'payment_metadata' => $paymentData,
            ]);

            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'Payment was not successful.');
        }

        $order->update([
            'status' => OrderStatus::Paid,
            'paystack_reference' => $paymentData['reference'] ?? $reference,
            'paid_at' => now(),
            'payment_metadata' => $paymentData,
        ]);

        $this->cart->clear();

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Thank you! Your payment was successful.');
    }

    public function show(Order $order): View
    {
        $order->load('items.product');

        return view('orders.show', [
            'order' => $order,
        ]);
    }
}
