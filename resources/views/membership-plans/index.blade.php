<x-app-layout>
    @include('admin.partials.flash')

    @include('admin.partials.page-header', [
        'title' => 'Membership Plans',
        'subtitle' => 'Manage monthly subscription tiers shown on the homepage.',
        'actionUrl' => route('membership-plans.create'),
        'actionLabel' => 'Add Plan',
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
                @forelse ($membershipPlans as $plan)
                    <tr class="border-b border-outline-variant/10 hover:bg-surface/50 transition-colors">
                        <td class="px-md py-md align-middle font-semibold">{{ $plan->name }}</td>
                        <td class="px-md py-md align-middle">₦{{ number_format($plan->price, 0) }}/{{ $plan->billing_interval }}</td>
                        <td class="px-md py-md align-middle text-on-surface-variant">{{ count($plan->features) }} items</td>
                        <td class="px-md py-md align-middle">
                            @if ($plan->is_featured)
                                <span class="inline-flex px-sm py-1 rounded-full text-label-sm bg-primary-container text-on-primary-container whitespace-nowrap">{{ $plan->badge_text ?? 'Featured' }}</span>
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-md py-md align-middle">{{ $plan->sort_order }}</td>
                        <td class="px-md py-md align-middle">
                            <span @class([
                                'inline-flex px-sm py-1 rounded-full text-label-sm whitespace-nowrap',
                                'bg-secondary-container text-on-secondary-container' => $plan->is_active,
                                'bg-surface-container text-on-surface-variant' => ! $plan->is_active,
                            ])>
                                {{ $plan->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </td>
                        <td class="px-md py-md align-middle">
                            <div class="flex justify-end gap-sm">
                                <a href="{{ route('membership-plans.show', $plan) }}" class="text-primary hover:underline text-label-sm">View</a>
                                <a href="{{ route('membership-plans.edit', $plan) }}" class="text-primary hover:underline text-label-sm">Edit</a>
                                <form method="POST" action="{{ route('membership-plans.destroy', $plan) }}" onsubmit="return confirm('Delete this plan?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-error hover:underline text-label-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-md py-xl text-center text-on-surface-variant">No membership plans yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($membershipPlans->hasPages())
        <div class="mt-md">{{ $membershipPlans->links() }}</div>
    @endif
</x-app-layout>
