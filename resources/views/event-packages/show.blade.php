<x-app-layout>
    @include('admin.partials.flash')

    @include('admin.partials.page-header', [
        'title' => $eventPackage->name,
        'subtitle' => $eventPackage->tagline,
        'actionUrl' => route('event-packages.edit', $eventPackage),
        'actionLabel' => 'Edit Package',
    ])

    <div class="max-w-xl bg-surface-container-lowest rounded-xl border border-outline-variant/20 shadow-sm p-md space-y-md">
        <p>
            <span class="text-on-surface-variant">Price:</span>
            @if ($eventPackage->hasCustomPricing())
                {{ $eventPackage->formattedPrice() }}
            @else
                {{ $eventPackage->formattedPrice() }}/{{ $eventPackage->price_interval }}
            @endif
        </p>
        <p><span class="text-on-surface-variant">Button:</span> {{ $eventPackage->button_text }}</p>
        <p><span class="text-on-surface-variant">Featured:</span> {{ $eventPackage->is_featured ? ($eventPackage->badge_text ?? 'Yes') : 'No' }}</p>
        <p><span class="text-on-surface-variant">Display order:</span> {{ $eventPackage->sort_order }}</p>
        <p><span class="text-on-surface-variant">Status:</span> {{ $eventPackage->is_active ? 'Active' : 'Hidden' }}</p>
        <div>
            <p class="text-on-surface-variant mb-sm">Features:</p>
            <ul class="space-y-xs">
                @foreach ($eventPackage->features as $feature)
                    <li class="flex items-center gap-sm">
                        <span class="material-symbols-outlined text-primary text-sm">check_circle</span>
                        {{ $feature }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
