<x-app-layout>
    <header class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-md mb-xl">
        <div>
            <h2 class="text-display-lg font-display-lg text-primary">My Account</h2>
            <p class="text-body-lg text-on-surface-variant">Your orders, event bookings, and membership options in one place.</p>
        </div>
        <a href="{{ route('shop') }}" class="bg-primary text-on-primary px-md py-sm rounded-full font-label-md flex items-center gap-sm hover:scale-105 transition-transform shadow-sm shrink-0">
            <span class="material-symbols-outlined">shopping_bag</span>
            Continue Shopping
        </a>
    </header>

    <section class="mb-xl">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-sm mb-md">
            <h3 class="text-headline-sm font-headline-sm text-on-surface">Previous Orders</h3>
        </div>
        <div class="bg-surface-container-lowest rounded-xl overflow-x-auto border border-outline-variant/20 shadow-sm">
            <table class="w-full min-w-[720px] text-left">
                <thead>
                    <tr class="bg-surface-container text-on-surface-variant text-label-md">
                        <th class="px-md py-sm align-middle">Order</th>
                        <th class="px-md py-sm align-middle">Date</th>
                        <th class="px-md py-sm align-middle">Items</th>
                        <th class="px-md py-sm align-middle">Total</th>
                        <th class="px-md py-sm align-middle">Status</th>
                        <th class="px-md py-sm align-middle text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-body-md">
                    @forelse ($orders as $order)
                        <tr class="border-b border-outline-variant/10 hover:bg-surface/50 transition-colors">
                            <td class="px-md py-md align-middle font-semibold">#{{ $order->reference }}</td>
                            <td class="px-md py-md align-middle">{{ $order->created_at->format('M j, Y') }}</td>
                            <td class="px-md py-md align-middle">{{ $order->items->sum('quantity') }}</td>
                            <td class="px-md py-md align-middle">₦{{ number_format($order->total_amount, 0) }}</td>
                            <td class="px-md py-md align-middle">
                                <span @class([
                                    'inline-flex px-sm py-1 rounded-full text-label-sm whitespace-nowrap',
                                    'bg-secondary-container text-on-secondary-container' => $order->isPaid(),
                                    'bg-error-container text-on-error-container' => $order->status === \App\OrderStatus::Failed,
                                    'bg-surface-container text-on-surface-variant' => $order->status === \App\OrderStatus::Pending,
                                ])>
                                    {{ $order->status->label() }}
                                </span>
                            </td>
                            <td class="px-md py-md align-middle text-right">
                                <a href="{{ route('orders.show', $order) }}" class="text-primary hover:underline text-label-sm">View</a>
                                @if ($order->status === \App\OrderStatus::Pending)
                                    <a href="{{ route('payment.initiate', $order) }}" class="text-primary hover:underline text-label-sm ml-sm">Pay</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-md py-xl text-center text-on-surface-variant">
                                No orders yet. <a href="{{ route('shop') }}" class="text-primary underline">Browse the shop</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="mb-xl">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-sm mb-md">
            <h3 class="text-headline-sm font-headline-sm text-on-surface">Event Bookings</h3>
            <a href="{{ route('event-services') }}" class="text-primary font-label-md hover:underline shrink-0">Book an event</a>
        </div>
        <div class="bg-surface-container-lowest rounded-xl overflow-x-auto border border-outline-variant/20 shadow-sm">
            <table class="w-full min-w-[720px] text-left">
                <thead>
                    <tr class="bg-surface-container text-on-surface-variant text-label-md">
                        <th class="px-md py-sm align-middle">Event</th>
                        <th class="px-md py-sm align-middle">Type</th>
                        <th class="px-md py-sm align-middle">Event Date</th>
                        <th class="px-md py-sm align-middle">Guests</th>
                        <th class="px-md py-sm align-middle">Status</th>
                        <th class="px-md py-sm align-middle">Progress</th>
                    </tr>
                </thead>
                <tbody class="text-body-md">
                    @forelse ($bookings as $booking)
                        <tr class="border-b border-outline-variant/10 hover:bg-surface/50 transition-colors">
                            <td class="px-md py-md align-middle font-semibold">{{ $booking->title }}</td>
                            <td class="px-md py-md align-middle">{{ $booking->event_type->label() }}</td>
                            <td class="px-md py-md align-middle">
                                {{ $booking->event_date?->format('M j, Y') ?? '—' }}
                            </td>
                            <td class="px-md py-md align-middle">
                                {{ $booking->guest_count ? number_format($booking->guest_count) : '—' }}
                            </td>
                            <td class="px-md py-md align-middle">
                                <span @class([
                                    'inline-flex px-sm py-1 rounded-full text-label-sm whitespace-nowrap',
                                    'bg-surface-container text-on-surface-variant' => $booking->status === \App\BookingStatus::InquiryReceived,
                                    'bg-secondary-container text-on-secondary-container' => $booking->status === \App\BookingStatus::Planning,
                                    'bg-primary-container text-on-primary-container' => $booking->status === \App\BookingStatus::InProduction,
                                    'bg-tertiary-container text-on-tertiary-container' => $booking->status === \App\BookingStatus::Completed,
                                ])>
                                    {{ $booking->status->label() }}
                                </span>
                            </td>
                            <td class="px-md py-md align-middle">
                                @if ($booking->status === \App\BookingStatus::InProduction)
                                    <div class="flex items-center gap-sm min-w-[120px]">
                                        <div class="flex-1 bg-surface-container rounded-full h-2">
                                            <div class="bg-primary h-full rounded-full" style="width: {{ $booking->progress }}%"></div>
                                        </div>
                                        <span class="text-label-sm text-on-surface-variant shrink-0">{{ $booking->progress }}%</span>
                                    </div>
                                @elseif ($booking->status === \App\BookingStatus::Completed)
                                    <span class="text-label-sm text-secondary font-bold">Delivered</span>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-md py-xl text-center text-on-surface-variant">
                                No event bookings yet. <a href="{{ route('event-services') }}" class="text-primary underline">Request event services</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section>
        <div class="text-center mb-xl">
            <h3 class="text-headline-md font-headline-md text-on-surface">Membership Plans</h3>
            <p class="text-on-surface-variant mt-sm">Subscribe to curated candy boxes delivered monthly.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-lg items-end">
            @forelse ($membershipPlans as $plan)
                <div @class([
                    'p-lg rounded-xl flex flex-col',
                    'bg-primary-container text-on-primary-container shadow-xl scale-105 z-10 min-h-[480px]' => $plan->is_featured,
                    'bg-surface-container-low border border-outline-variant hover:border-primary transition-all h-full' => ! $plan->is_featured,
                ])>
                    <div class="flex justify-between items-start mb-xs">
                        <h4 class="font-bold text-headline-sm">{{ $plan->name }}</h4>
                        @if ($plan->badge_text)
                            <span @class([
                                'px-sm py-xs rounded-full text-[10px] font-bold uppercase tracking-wider shrink-0',
                                'bg-white/20' => $plan->is_featured,
                                'bg-primary-container text-on-primary-container' => ! $plan->is_featured,
                            ])>{{ $plan->badge_text }}</span>
                        @endif
                    </div>
                    <p @class([
                        'text-label-md mb-md',
                        'opacity-80' => $plan->is_featured,
                        'text-on-surface-variant' => ! $plan->is_featured,
                    ])>{{ $plan->tagline }}</p>
                    <div class="mb-lg">
                        <span class="text-4xl font-extrabold @if (! $plan->is_featured) text-on-surface @endif">₦{{ number_format($plan->price, 0) }}</span>
                        <span @class([
                            'opacity-80' => $plan->is_featured,
                            'text-on-surface-variant' => ! $plan->is_featured,
                        ])>/{{ $plan->billing_interval }}</span>
                    </div>
                    <ul class="space-y-sm mb-xl flex-grow">
                        @foreach ($plan->features as $feature)
                            <li @class([
                                'flex items-center gap-sm',
                                'text-on-surface-variant' => ! $plan->is_featured,
                            ])>
                                <span class="material-symbols-outlined @if (! $plan->is_featured) text-primary @endif">check_circle</span>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                    <button
                        type="button"
                        @class([
                            'w-full py-sm rounded-full font-bold transition-all',
                            'bg-on-primary-container text-primary-container shadow-lg hover:brightness-110' => $plan->is_featured,
                            'border-2 border-primary text-primary hover:bg-primary/5 transition-colors' => ! $plan->is_featured,
                        ])
                    >{{ $plan->button_text }}</button>
                </div>
            @empty
                <div class="md:col-span-3 text-center py-xl text-on-surface-variant">
                    Membership plans coming soon.
                </div>
            @endforelse
        </div>
    </section>
</x-app-layout>
