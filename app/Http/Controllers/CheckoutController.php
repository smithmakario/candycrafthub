<?php

namespace App\Http\Controllers;

use App\FulfillmentType;
use App\Http\Requests\StoreCheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\OrderStatus;
use App\PaymentMethod;
use App\Services\CartService;
use App\UserType;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CartService $cart,
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
            'paymentMethods' => PaymentMethod::cases(),
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
        $reference = Order::generateReference();
        $validated = $request->validated();
        $fulfillmentType = FulfillmentType::from($validated['fulfillment_type']);
        $paymentMethod = PaymentMethod::from($validated['payment_method']);
        $user = $request->user() ?? $this->resolveGuestUser($request, $validated, $fulfillmentType);

        $order = DB::transaction(function () use ($lines, $reference, $validated, $fulfillmentType, $paymentMethod, $user): Order {
            $order = Order::query()->create([
                'user_id' => $user->id,
                'email' => $user->email,
                'fulfillment_type' => $fulfillmentType,
                'delivery_address' => $fulfillmentType === FulfillmentType::Delivery
                    ? $validated['delivery_address']
                    : null,
                'reference' => $reference,
                'payment_method' => $paymentMethod,
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

        if ($paymentMethod === PaymentMethod::BankTransfer) {
            $this->cart->clear();

            return redirect()
                ->route('orders.show', $order)
                ->with('success', 'Order placed. Please complete your bank transfer using the details below.');
        }

        return redirect()->route('payment.initiate', $order);
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    private function resolveGuestUser(StoreCheckoutRequest $request, array $validated, FulfillmentType $fulfillmentType): User
    {
        if ($validated['account_mode'] === 'login') {
            if (! Auth::attempt($request->only('email', 'password'))) {
                throw ValidationException::withMessages([
                    'email' => __('These credentials do not match our records.'),
                ]);
            }

            $request->session()->regenerate();

            /** @var User $user */
            $user = $request->user();

            if (! $user->isCustomer()) {
                Auth::logout();

                throw ValidationException::withMessages([
                    'email' => 'Please use a customer account to complete checkout.',
                ]);
            }

            return $user;
        }

        $user = User::query()->create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? '',
            'address' => $fulfillmentType === FulfillmentType::Delivery
                ? ($validated['delivery_address'] ?? '')
                : '',
            'state' => '',
            'country' => 'Nigeria',
            'user_type' => UserType::Customer,
        ]);

        event(new Registered($user));

        Auth::login($user);
        $request->session()->regenerate();

        return $user;
    }
}
