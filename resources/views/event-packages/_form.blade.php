@php
    $packageModel = $eventPackage ?? null;
    $featuresText = old('features', $packageModel ? implode("\n", $packageModel->features) : '');
    $usesCustomPricing = old('uses_custom_pricing', $packageModel?->hasCustomPricing() ?? false);
@endphp

<form
    method="POST"
    action="{{ $packageModel ? route('event-packages.update', $packageModel) : route('event-packages.store') }}"
    class="max-w-2xl bg-surface-container-lowest rounded-xl border border-outline-variant/20 shadow-sm p-md md:p-xl space-y-md"
    id="event-package-form"
>
    @csrf
    @if ($packageModel)
        @method('PUT')
    @endif

    <div>
        <label for="name" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Package Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $packageModel?->name) }}" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
    </div>

    <div>
        <label for="tagline" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Tagline</label>
        <input id="tagline" name="tagline" type="text" value="{{ old('tagline', $packageModel?->tagline) }}" placeholder="e.g. Up to 30 guests" class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
    </div>

    <div>
        <label class="flex items-center gap-sm text-label-md text-on-surface mb-md">
            <input type="checkbox" name="uses_custom_pricing" value="1" id="uses_custom_pricing" @checked($usesCustomPricing) class="rounded border-secondary text-primary focus:ring-primary">
            Custom pricing (no fixed price)
        </label>
    </div>

    <div id="fixed-price-fields" @class(['hidden' => $usesCustomPricing])>
        <div>
            <label for="price" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Price (₦)</label>
            <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price', $packageModel?->price) }}" class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
        </div>
    </div>

    <div id="custom-price-fields" @class(['hidden' => ! $usesCustomPricing])>
        <div>
            <label for="price_label" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Price Label</label>
            <input id="price_label" name="price_label" type="text" value="{{ old('price_label', $packageModel?->price_label ?? 'Custom') }}" placeholder="e.g. Custom" class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
        </div>
    </div>

    <div>
        <label for="price_interval" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Price Interval</label>
        <input id="price_interval" name="price_interval" type="text" value="{{ old('price_interval', $packageModel?->price_interval ?? 'event') }}" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
    </div>

    <div>
        <label for="features" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Features (one per line)</label>
        <textarea id="features" name="features" rows="5" required class="w-full rounded-xl border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">{{ $featuresText }}</textarea>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
        <div>
            <label for="button_text" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Button Text</label>
            <input id="button_text" name="button_text" type="text" value="{{ old('button_text', $packageModel?->button_text ?? 'Get a Quote') }}" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
        </div>
        <div>
            <label for="badge_text" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Badge Text</label>
            <input id="badge_text" name="badge_text" type="text" value="{{ old('badge_text', $packageModel?->badge_text) }}" placeholder="e.g. Most Popular" class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
        </div>
    </div>

    <div>
        <label for="sort_order" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Display Order</label>
        <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $packageModel?->sort_order ?? 0) }}" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
    </div>

    <div class="flex flex-col sm:flex-row gap-md">
        <label class="flex items-center gap-sm text-label-md text-on-surface">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $packageModel?->is_featured)) class="rounded border-secondary text-primary focus:ring-primary">
            Featured package (highlighted card)
        </label>
        <label class="flex items-center gap-sm text-label-md text-on-surface">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $packageModel?->is_active ?? true)) class="rounded border-secondary text-primary focus:ring-primary">
            Active on website
        </label>
    </div>

    <div class="flex gap-md pt-md">
        <a href="{{ route('event-packages.index') }}" class="flex-1 py-md rounded-full border-2 border-primary text-primary font-bold text-center hover:bg-primary/5 transition-colors">Cancel</a>
        <button type="submit" class="flex-1 py-md rounded-full bg-primary text-on-primary font-bold hover:opacity-90 transition-opacity shadow-md">
            {{ $packageModel ? 'Update Package' : 'Create Package' }}
        </button>
    </div>
</form>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const customPricingToggle = document.getElementById('uses_custom_pricing');
            const fixedPriceFields = document.getElementById('fixed-price-fields');
            const customPriceFields = document.getElementById('custom-price-fields');
            const priceInput = document.getElementById('price');
            const priceLabelInput = document.getElementById('price_label');

            const updatePricingFields = () => {
                const usesCustom = customPricingToggle.checked;
                fixedPriceFields.classList.toggle('hidden', usesCustom);
                customPriceFields.classList.toggle('hidden', ! usesCustom);
                priceInput.required = ! usesCustom;
                priceLabelInput.required = usesCustom;
            };

            customPricingToggle.addEventListener('change', updatePricingFields);
            updatePricingFields();
        });
    </script>
@endpush
