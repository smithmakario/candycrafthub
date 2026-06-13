<section class="py-xl px-margin-mobile md:px-margin-desktop bg-surface">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-xl">
            <h2 class="text-headline-md font-headline-md text-on-surface">Event Packages</h2>
            <p class="text-on-surface-variant mt-sm">Flexible tiers for intimate gatherings to large-scale celebrations.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-lg items-end">
            @forelse ($eventPackages as $package)
                <div @class([
                    'p-lg rounded-xl flex flex-col',
                    'bg-primary-container text-on-primary-container shadow-xl scale-105 z-10 min-h-[520px]' => $package->is_featured,
                    'bg-surface-container-low border border-outline-variant hover:border-primary transition-all h-full' => ! $package->is_featured,
                ])>
                    <div class="flex justify-between items-start gap-sm mb-xs">
                        <h3 class="font-bold text-headline-sm min-w-0">{{ $package->name }}</h3>
                        @if ($package->is_featured)
                            <span class="bg-white/20 px-sm py-xs rounded-full text-[10px] font-bold uppercase tracking-wider shrink-0 whitespace-nowrap">
                                {{ $package->badge_text ?: 'Most Popular' }}
                            </span>
                        @endif
                    </div>
                    @if ($package->tagline)
                        <p @class([
                            'text-label-md mb-md',
                            'opacity-80' => $package->is_featured,
                            'text-on-surface-variant' => ! $package->is_featured,
                        ])>{{ $package->tagline }}</p>
                    @endif
                    <div class="mb-lg">
                        <span class="text-4xl font-extrabold @if (! $package->is_featured) text-on-surface @endif">{{ $package->formattedPrice() }}</span>
                        @if (! $package->hasCustomPricing())
                            <span @class([
                                'opacity-80' => $package->is_featured,
                                'text-on-surface-variant' => ! $package->is_featured,
                            ])>/{{ $package->price_interval }}</span>
                        @endif
                    </div>
                    <ul class="space-y-sm mb-xl flex-grow">
                        @foreach ($package->features as $feature)
                            <li @class([
                                'flex items-center gap-sm',
                                'text-on-surface-variant' => ! $package->is_featured,
                            ])>
                                <span class="material-symbols-outlined @if (! $package->is_featured) text-primary @endif">check_circle</span>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                    <a href="#intake-form"
                        @class([
                            'block w-full py-sm rounded-full font-bold text-center transition-all',
                            'bg-on-primary-container text-primary-container shadow-lg hover:brightness-110' => $package->is_featured,
                            'border-2 border-primary text-primary hover:bg-primary/5 transition-colors' => ! $package->is_featured,
                        ])
                    >{{ $package->button_text }}</a>
                </div>
            @empty
                <div class="md:col-span-3 text-center py-xl text-on-surface-variant">
                    Event packages coming soon.
                </div>
            @endforelse
        </div>
    </div>
</section>
