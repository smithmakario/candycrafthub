<x-app-layout>
    @include('admin.partials.flash')

    @include('admin.partials.page-header', [
        'title' => 'Event Packages',
        'subtitle' => 'Manage pricing tiers shown on the event services page.',
        'actionUrl' => route('event-packages.create'),
        'actionLabel' => 'Add Package',
    ])

    <div class="bg-surface-container-lowest rounded-xl overflow-x-auto border border-outline-variant/20 shadow-sm">
        <table class="w-full min-w-[800px] text-left">
            <thead>
                <tr class="bg-surface-container text-on-surface-variant text-label-md">
                    <th class="px-md py-sm align-middle">Name</th>
                    <th class="px-md py-sm align-middle">Price</th>
                    <th class="px-md py-sm align-middle">Features</th>
                    <th class="px-md py-sm align-middle">Featured</th>
                    <th class="px-md py-sm align-middle">Order</th>
                    <th class="px-md py-sm align-middle">Status</th>
                    <th class="px-md py-sm align-middle text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-body-md">
                @forelse ($eventPackages as $package)
                    <tr class="border-b border-outline-variant/10 hover:bg-surface/50 transition-colors">
                        <td class="px-md py-md align-middle font-semibold">{{ $package->name }}</td>
                        <td class="px-md py-md align-middle">
                            @if ($package->hasCustomPricing())
                                {{ $package->formattedPrice() }}
                            @else
                                {{ $package->formattedPrice() }}/{{ $package->price_interval }}
                            @endif
                        </td>
                        <td class="px-md py-md align-middle text-on-surface-variant">{{ count($package->features) }} items</td>
                        <td class="px-md py-md align-middle">
                            @if ($package->is_featured)
                                <span class="inline-flex px-sm py-1 rounded-full text-label-sm bg-primary-container text-on-primary-container whitespace-nowrap">{{ $package->badge_text ?? 'Featured' }}</span>
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-md py-md align-middle">{{ $package->sort_order }}</td>
                        <td class="px-md py-md align-middle">
                            <span @class([
                                'inline-flex px-sm py-1 rounded-full text-label-sm whitespace-nowrap',
                                'bg-secondary-container text-on-secondary-container' => $package->is_active,
                                'bg-surface-container text-on-surface-variant' => ! $package->is_active,
                            ])>
                                {{ $package->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </td>
                        <td class="px-md py-md align-middle">
                            <div class="flex justify-end gap-sm">
                                <a href="{{ route('event-packages.show', $package) }}" class="text-primary hover:underline text-label-sm">View</a>
                                <a href="{{ route('event-packages.edit', $package) }}" class="text-primary hover:underline text-label-sm">Edit</a>
                                <form method="POST" action="{{ route('event-packages.destroy', $package) }}" onsubmit="return confirm('Delete this package?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-error hover:underline text-label-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-md py-xl text-center text-on-surface-variant">No event packages yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($eventPackages->hasPages())
        <div class="mt-md">{{ $eventPackages->links() }}</div>
    @endif
</x-app-layout>
