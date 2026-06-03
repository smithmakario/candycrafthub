<section class="py-xl px-margin-mobile md:px-margin-desktop bg-surface">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-xl">
            <h2 class="text-headline-md font-headline-md text-on-surface">Monthly Membership Plans</h2>
            <p class="text-on-surface-variant mt-sm">Cancel or skip a month anytime. No strings attached.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-lg items-end">
            @forelse ($membershipPlans as $plan)
                <div @class([
                    'p-lg rounded-xl flex flex-col',
                    'bg-primary-container text-on-primary-container shadow-xl scale-105 z-10 h-[520px]' => $plan->is_featured,
                    'bg-surface-container-low border border-outline-variant hover:border-primary transition-all h-full' => ! $plan->is_featured,
                ])>
                    <div class="flex justify-between items-start mb-xs">
                        <h3 class="font-bold text-headline-sm">{{ $plan->name }}</h3>
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
    </div>
</section>
