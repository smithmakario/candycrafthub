<section class="py-xl bg-surface-container-low px-margin-mobile md:px-margin-desktop overflow-hidden" id="intake-form">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-xl">
            <h2 class="font-headline-md text-headline-md text-primary mb-sm">Build Your Own Candy Experience</h2>
            <p class="text-on-surface-variant">Let's craft your dream sweet spread in three simple steps.</p>
        </div>

        @if (session('booking_success'))
            <div class="glass-card rounded-xl shadow-md p-md md:p-xl text-center py-xl">
                <span class="material-symbols-outlined text-[80px] text-secondary mb-md">check_circle</span>
                <h3 class="font-headline-md text-headline-md text-primary mb-sm">Inquiry Received!</h3>
                <p class="text-on-surface-variant mb-lg">Our master curater will reach out within 24 hours to begin crafting your sweet vision.</p>
                <a href="{{ route('event-services') }}" class="text-primary font-bold underline">Submit another inquiry</a>
            </div>
        @else
            <form method="POST" action="{{ route('bookings.store-public') }}" id="intake-form-element" data-has-errors="{{ $errors->any() ? '1' : '0' }}" class="glass-card rounded-xl shadow-md p-md md:p-xl relative">
                @csrf
                <input type="hidden" name="event_type" id="event-type-input" value="{{ old('event_type') }}">
                <input type="hidden" name="theme_color" id="theme-color-input" value="{{ old('theme_color') }}">

                @if ($errors->any())
                    <div class="mb-md rounded-xl bg-error-container text-on-error-container px-md py-sm text-label-md">
                        <ul class="list-disc list-inside space-y-xs">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex justify-between mb-xl relative" id="progress-container">
                    <div class="absolute top-1/2 left-0 w-full h-1 bg-outline-variant -translate-y-1/2 z-0"></div>
                    <div class="absolute top-1/2 left-0 w-0 h-1 bg-primary -translate-y-1/2 z-0 transition-all duration-500" id="progress-bar"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold" id="step-marker-1">1</div>
                        <span class="text-label-sm font-label-sm mt-xs text-primary" id="step-label-1">Event</span>
                    </div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center font-bold transition-colors" id="step-marker-2">2</div>
                        <span class="text-label-sm font-label-sm mt-xs text-on-surface-variant" id="step-label-2">Theme</span>
                    </div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center font-bold transition-colors" id="step-marker-3">3</div>
                        <span class="text-label-sm font-label-sm mt-xs text-on-surface-variant" id="step-label-3">Details</span>
                    </div>
                </div>

                <div class="step-transition" id="step-1">
                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-lg">What's the occasion?</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                        <button type="button" class="intake-event-choice flex flex-col items-center p-lg rounded-xl border-2 border-outline-variant hover:border-primary hover:bg-primary/5 transition-all text-center group" data-event-type="wedding">
                            <span class="material-symbols-outlined text-[48px] text-primary mb-md group-hover:scale-110 transition-transform">favorite</span>
                            <span class="font-label-md text-label-md">Wedding</span>
                        </button>
                        <button type="button" class="intake-event-choice flex flex-col items-center p-lg rounded-xl border-2 border-outline-variant hover:border-primary hover:bg-primary/5 transition-all text-center group" data-event-type="corporate">
                            <span class="material-symbols-outlined text-[48px] text-primary mb-md group-hover:scale-110 transition-transform">business_center</span>
                            <span class="font-label-md text-label-md">Corporate</span>
                        </button>
                        <button type="button" class="intake-event-choice flex flex-col items-center p-lg rounded-xl border-2 border-outline-variant hover:border-primary hover:bg-primary/5 transition-all text-center group" data-event-type="birthday">
                            <span class="material-symbols-outlined text-[48px] text-primary mb-md group-hover:scale-110 transition-transform">celebration</span>
                            <span class="font-label-md text-label-md">Birthday</span>
                        </button>
                    </div>
                </div>

                <div class="hidden step-transition" id="step-2">
                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-lg">Pick Your Color Theme</h3>
                    <div class="flex flex-col items-center gap-lg">
                        <div class="flex flex-wrap justify-center gap-md">
                            <button type="button" class="theme-swatch w-16 h-16 rounded-full bg-primary ring-4 ring-white shadow-sm hover:scale-110 transition-transform" data-color="#864d61" title="Cotton Candy Pink"></button>
                            <button type="button" class="theme-swatch w-16 h-16 rounded-full bg-secondary ring-2 ring-white shadow-sm hover:scale-110 transition-transform" data-color="#346664" title="Sky Blue"></button>
                            <button type="button" class="theme-swatch w-16 h-16 rounded-full bg-tertiary-container ring-2 ring-white shadow-sm hover:scale-110 transition-transform" data-color="#e9c85d" title="Honey Yellow"></button>
                            <button type="button" class="theme-swatch w-16 h-16 rounded-full bg-inverse-surface ring-2 ring-white shadow-sm hover:scale-110 transition-transform" data-color="#402c18" title="Chocolate Brown"></button>
                            <button type="button" class="theme-swatch w-16 h-16 rounded-full bg-secondary-fixed-dim ring-2 ring-white shadow-sm hover:scale-110 transition-transform" data-color="#9cd0cd" title="Mint Green"></button>
                        </div>
                        <div class="w-full">
                            <label class="block text-label-md font-label-md mb-xs text-on-surface-variant" for="custom-hex">Or specify custom hex code</label>
                            <input class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50" id="custom-hex" placeholder="#864d61" type="text" value="{{ old('theme_color') }}">
                        </div>
                        <div class="flex gap-md w-full">
                            <button type="button" class="flex-1 py-md rounded-full border-2 border-primary text-primary font-bold hover:bg-primary/5 transition-colors" onclick="nextStep(1)">Back</button>
                            <button type="button" class="flex-1 py-md rounded-full bg-primary text-on-primary font-bold hover:opacity-90 transition-opacity shadow-md" onclick="nextStep(3)">Continue</button>
                        </div>
                    </div>
                </div>

                <div class="hidden step-transition" id="step-3">
                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-lg">Final Details</h3>
                    <div class="space-y-md">
                        <div>
                            <label class="block text-label-md font-label-md mb-xs text-on-surface-variant" for="guest-count">Estimated Guest Count</label>
                            <input class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50" id="guest-count" name="guest_count" placeholder="e.g. 150" type="number" min="1" value="{{ old('guest_count') }}">
                        </div>
                        <div>
                            <label class="block text-label-md font-label-md mb-xs text-on-surface-variant" for="event-date">Event Date</label>
                            <input class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50" id="event-date" name="event_date" type="date" value="{{ old('event_date') }}">
                        </div>
                        <div class="flex gap-md w-full pt-lg">
                            <button type="button" class="flex-1 py-md rounded-full border-2 border-primary text-primary font-bold hover:bg-primary/5 transition-colors" onclick="nextStep(2)">Back</button>
                            <button type="submit" class="flex-1 py-md rounded-full bg-[#e9c85d] text-[#402c18] font-bold hover:scale-105 transition-transform shadow-md">Build My Experience</button>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    </div>
</section>
