<?php

namespace App\Http\Controllers;

use App\FulfillmentType;
use App\Http\Requests\StoreCheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\OrderStatus;
use App\Services\CartService;
use App\Services\PaystackService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CartService $cart,
        private readonly PaystackService $paystack,
    ) {}

    public function create(): View|RedirectResponse
    {
        if ($this->cart->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        return view('checkout.create', [
            'lines' => $this->cart->lines(),
            'subtotal' => $this->cart->subtotal(),
        ]);
    }

    public function store(StoreCheckoutRequest $request): RedirectResponse
    {
        if ($this->cart->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $lines = $this->cart->lines();
        $reference = $this->paystack->generateReference();
        $validated = $request->validated();
        $fulfillmentType = FulfillmentType::from($validated['fulfillment_type']);

        $order = DB::transaction(function () use ($lines, $reference, $validated, $fulfillmentType, $request): Order {
            $order = Order::query()->create([
                'user_id' => $request->user()?->id,
                'email' => $validated['email'],
                'fulfillment_type' => $fulfillmentType,
                'delivery_address' => $fulfillmentType === FulfillmentType::Delivery
                    ? $validated['delivery_address']
                    : null,
                'reference' => $reference,
                'status' => OrderStatus::Pending,
                'total_amount' => $lines->sum('line_total'),
                'currency' => 'NGN',
            ]);

            foreach ($lines as $line) {
                OrderItem::query()->create([
                    'order_id' => $order->id,
                    'product_id' => $line['product']->id,
                    'product_name' => $line['product']->name,
                    'quantity' => $line['quantity'],
                    'unit_price' => $line['product']->unit_price,
                    'line_total' => $line['line_total'],
                ]);
            }

            return $order;
        });

        return redirect()->route('payment.initiate', $order);
    }
}
