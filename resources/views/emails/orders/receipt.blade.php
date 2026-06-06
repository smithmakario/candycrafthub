<x-mail::message>
# Payment confirmed

Hi there,

Your payment for order **#{{ $order->reference }}** has been confirmed. Thank you for shopping with Candy Craft Hub!

## Order summary

**Total:** ₦{{ number_format($order->total_amount, 0) }}

**Paid at:** {{ $order->paid_at?->format('M j, Y g:i A') }}

**Payment method:** {{ $order->payment_method->label() }}

@if ($bankAccountLabel)
**Paid to:** {{ $bankAccountLabel }}
@endif

**Fulfillment:** {{ $order->fulfillment_type->label() }}

@if ($order->fulfillment_type === \App\FulfillmentType::Delivery && $order->delivery_address)
**Delivery address:**

{{ $order->delivery_address }}
@endif

## Items

@foreach ($order->items as $item)
- {{ $item->product_name }} × {{ $item->quantity }} — ₦{{ number_format($item->line_total, 0) }}
@endforeach

<x-mail::button :url="route('orders.show', $order)">
View order
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
