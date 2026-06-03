<x-app-layout>
    @include('admin.partials.flash')

    @include('admin.partials.page-header', [
        'title' => $membershipPlan->name,
        'subtitle' => $membershipPlan->tagline,
        'actionUrl' => route('membership-plans.edit', $membershipPlan),
        'actionLabel' => 'Edit Plan',
    ])

    <div class="max-w-xl bg-surface-container-lowest rounded-xl border border-outline-variant/20 shadow-sm p-md space-y-md">
        <p><span class="text-on-surface-variant">Price:</span> ₦{{ number_format($membershipPlan->price, 0) }}/{{ $membershipPlan->billing_interval }}</p>
        <p><span class="text-on-surface-variant">Button:</span> {{ $membershipPlan->button_text }}</p>
        <p><span class="text-on-surface-variant">Featured:</span> {{ $membershipPlan->is_featured ? ($membershipPlan->badge_text ?? 'Yes') : 'No' }}</p>
        <p><span class="text-on-surface-variant">Display order:</span> {{ $membershipPlan->sort_order }}</p>
        <p><span class="text-on-surface-variant">Status:</span> {{ $membershipPlan->is_active ? 'Active' : 'Hidden' }}</p>
        <div>
            <p class="text-on-surface-variant mb-sm">Features:</p>
            <ul class="space-y-xs">
                @foreach ($membershipPlan->features as $feature)
                    <li class="flex items-center gap-sm">
                        <span class="material-symbols-outlined text-primary text-sm">check_circle</span>
                        {{ $feature }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
