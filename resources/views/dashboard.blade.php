<x-app-layout>
    <header class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-md mb-xl">
        <div>
            <h2 class="text-display-lg font-display-lg text-primary">Sweet Overview</h2>
            <p class="text-body-lg text-on-surface-variant">The heartbeat of Candy Craft Hub today.</p>
        </div>
        <div class="flex flex-wrap gap-md shrink-0">
            <a href="{{ route('bookings.create') }}" class="bg-primary text-on-primary px-md py-sm rounded-full font-label-md flex items-center gap-sm hover:scale-105 transition-transform shadow-sm">
                <span class="material-symbols-outlined">add</span>
                New Booking
            </a>
        </div>
    </header>

    <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-gutter mb-xl">
        <div class="bg-surface-container-lowest p-md rounded-xl shadow-sm border border-outline-variant/10 hover:shadow-md transition-shadow flex flex-col">
            <div class="flex justify-between items-start mb-sm min-h-[40px]">
                <div class="p-xs bg-secondary-container rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">payments</span>
                </div>
            </div>
            <p class="text-label-md text-on-surface-variant">Total Products</p>
            <h3 class="text-headline-sm font-headline-sm text-on-surface mt-xs">{{ number_format($productCount) }}</h3>
        </div>

        <div class="bg-surface-container-lowest p-md rounded-xl shadow-sm border border-outline-variant/10 hover:shadow-md transition-shadow flex flex-col">
            <div class="flex justify-between items-start mb-sm min-h-[40px]">
                <div class="p-xs bg-primary-container rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">celebration</span>
                </div>
                @if ($newInquiriesCount > 0)
                    <span class="text-label-sm text-primary font-bold">{{ $newInquiriesCount }} New</span>
                @endif
            </div>
            <p class="text-label-md text-on-surface-variant">Event Bookings</p>
            <h3 class="text-headline-sm font-headline-sm text-on-surface mt-xs">{{ $activeBookingsCount }} Active</h3>
        </div>

        <div class="bg-surface-container-lowest p-md rounded-xl shadow-sm border border-outline-variant/10 hover:shadow-md transition-shadow flex flex-col">
            <div class="flex justify-between items-start mb-sm min-h-[40px]">
                <div class="p-xs bg-error-container rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">warning</span>
                </div>
                @if ($lowStockCount > 0)
                    <span class="text-label-sm text-error font-bold">Critical</span>
                @endif
            </div>
            <p class="text-label-md text-on-surface-variant">Low-Stock Alerts</p>
            <h3 class="text-headline-sm font-headline-sm text-on-surface mt-xs">{{ $lowStockCount }} Items</h3>
        </div>

        <div class="bg-surface-container-lowest p-md rounded-xl shadow-sm border border-outline-variant/10 hover:shadow-md transition-shadow flex flex-col">
            <div class="flex justify-between items-start mb-sm min-h-[40px]">
                <div class="p-xs bg-tertiary-container rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-tertiary-container" style="font-variation-settings: 'FILL' 1;">star</span>
                </div>
                <span class="text-label-sm font-bold invisible" aria-hidden="true">—</span>
            </div>
            <p class="text-label-md text-on-surface-variant">Top-Selling Category</p>
            <h3 class="text-headline-sm font-headline-sm text-on-surface mt-xs">{{ $topCategory }}</h3>
        </div>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-xl items-start">
        <section class="lg:col-span-2 flex flex-col gap-md min-w-0">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-sm min-h-[44px]">
                <h3 class="text-headline-sm font-headline-sm text-on-surface">Inventory Snapshot</h3>
                <a href="{{ route('inventory.index') }}" class="text-primary font-label-md hover:underline">Manage inventory</a>
            </div>
            <div class="bg-surface-container-lowest rounded-xl overflow-x-auto border border-outline-variant/20 shadow-sm">
                <table class="w-full min-w-[640px] text-left">
                    <thead>
                        <tr class="bg-surface-container text-on-surface-variant text-label-md">
                            <th class="px-md py-sm align-middle">Product Name</th>
                            <th class="px-md py-sm align-middle">Origin</th>
                            <th class="px-md py-sm align-middle">Stock Level</th>
                            <th class="px-md py-sm align-middle">Unit Price</th>
                            <th class="px-md py-sm align-middle">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-body-md">
                        @forelse ($inventoryItems as $item)
                            <tr class="border-b border-outline-variant/10 hover:bg-surface/50 transition-colors">
                                <td class="px-md py-md align-middle font-semibold">{{ $item->product->name }}</td>
                                <td class="px-md py-md align-middle">{{ $item->product->origin->label() }}</td>
                                <td class="px-md py-md align-middle">{{ number_format($item->quantity) }} units</td>
                                <td class="px-md py-md align-middle">₦{{ number_format($item->product->unit_price, 0) }}</td>
                                <td class="px-md py-md align-middle">
                                    <span @class([
                                        'inline-flex px-sm py-1 rounded-full text-label-sm whitespace-nowrap',
                                        'bg-secondary-container text-on-secondary-container' => ! $item->isLowStock(),
                                        'bg-error-container text-on-error-container' => $item->isLowStock(),
                                    ])>
                                        {{ $item->stockStatusLabel() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-md py-xl text-center text-on-surface-variant">
                                    No inventory yet. <a href="{{ route('inventory.create') }}" class="text-primary underline">Add stock</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="flex flex-col gap-md min-w-0">
            <div class="flex items-center min-h-[44px]">
                <h3 class="text-headline-sm font-headline-sm text-on-surface">Quick Links</h3>
            </div>
            <div class="bg-surface-container-high rounded-xl p-md flex flex-col gap-md">
                <a href="{{ route('products.index') }}" class="bg-surface-container-lowest p-sm rounded-lg shadow-sm hover:border-primary/40 border border-transparent transition-colors flex items-center gap-sm">
                    <span class="material-symbols-outlined text-primary">inventory_2</span>
                    <span class="font-label-md">Manage Products</span>
                </a>
                <a href="{{ route('inventory.index') }}" class="bg-surface-container-lowest p-sm rounded-lg shadow-sm hover:border-primary/40 border border-transparent transition-colors flex items-center gap-sm">
                    <span class="material-symbols-outlined text-primary">warehouse</span>
                    <span class="font-label-md">Manage Inventory</span>
                </a>
                <a href="{{ route('bookings.index') }}" class="bg-surface-container-lowest p-sm rounded-lg shadow-sm hover:border-primary/40 border border-transparent transition-colors flex items-center gap-sm">
                    <span class="material-symbols-outlined text-primary">event_available</span>
                    <span class="font-label-md">View Bookings Pipeline</span>
                </a>
            </div>
        </section>
    </div>

    <section class="mt-xl">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-sm mb-md">
            <h3 class="text-headline-sm font-headline-sm text-on-surface">Event Booking Pipeline</h3>
            <a class="text-primary font-label-md flex items-center gap-xs hover:underline shrink-0" href="{{ route('bookings.index') }}">
                View All Pipeline
                <span class="material-symbols-outlined">arrow_forward</span>
            </a>
        </div>
        <div class="flex gap-gutter overflow-x-auto pb-md custom-scrollbar min-h-[450px]">
            @foreach ($statuses as $status)
                @php
                    $bookings = $bookingsByStatus[$status->value];
                @endphp
                <div class="flex flex-col gap-sm min-w-[280px] flex-1">
                    <div class="flex items-center gap-sm px-sm min-h-[28px]">
                        <div @class(['w-2 h-2 rounded-full shrink-0', $status->dotColorClass()])></div>
                        <h4 class="text-label-md font-bold text-on-surface-variant">{{ $status->label() }} ({{ $bookings->count() }})</h4>
                    </div>
                    <div class="flex flex-col gap-md bg-surface-container/30 p-sm rounded-xl flex-1 border border-dashed border-outline-variant">
                        @forelse ($bookings as $booking)
                            @include('bookings.partials.card', ['booking' => $booking])
                        @empty
                            <p class="text-label-sm text-on-surface-variant text-center py-md">No bookings yet.</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-app-layout>
