@php
    $planModel = $membershipPlan ?? null;
    $featuresText = old('features', $planModel ? implode("\n", $planModel->features) : '');
@endphp

<form
    method="POST"
    action="{{ $planModel ? route('membership-plans.update', $planModel) : route('membership-plans.store') }}"
    class="max-w-2xl bg-surface-container-lowest rounded-xl border border-outline-variant/20 shadow-sm p-md md:p-xl space-y-md"
>
    @csrf
    @if ($planModel)
        @method('PUT')
    @endif

    <div>
        <label for="name" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Plan Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $planModel?->name) }}" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
    </div>

    <div>
        <label for="tagline" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Tagline</label>
        <input id="tagline" name="tagline" type="text" value="{{ old('tagline', $planModel?->tagline) }}" class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
        <div>
            <label for="price" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Price (₦)</label>
            <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price', $planModel?->price) }}" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
        </div>
        <div>
            <label for="billing_interval" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Billing Interval</label>
            <input id="billing_interval" name="billing_interval" type="text" value="{{ old('billing_interval', $planModel?->billing_interval ?? 'mo') }}" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
        </div>
    </div>

    <div>
        <label for="features" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Features (one per line)</label>
        <textarea id="features" name="features" rows="5" required class="w-full rounded-xl border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">{{ $featuresText }}</textarea>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
        <div>
            <label for="button_text" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Button Text</label>
            <input id="button_text" name="button_text" type="text" value="{{ old('button_text', $planModel?->button_text ?? 'Select Plan') }}" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
        </div>
        <div>
            <label for="badge_text" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Badge Text</label>
            <input id="badge_text" name="badge_text" type="text" value="{{ old('badge_text', $planModel?->badge_text) }}" placeholder="e.g. Most Popular" class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
        </div>
    </div>

    <div>
        <label for="sort_order" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Display Order</label>
        <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $planModel?->sort_order ?? 0) }}" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
    </div>

    <div class="flex flex-col sm:flex-row gap-md">
        <label class="flex items-center gap-sm text-label-md text-on-surface">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $planModel?->is_featured)) class="rounded border-secondary text-primary focus:ring-primary">
            Featured plan (highlighted card)
        </label>
        <label class="flex items-center gap-sm text-label-md text-on-surface">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $planModel?->is_active ?? true)) class="rounded border-secondary text-primary focus:ring-primary">
            Active on website
        </label>
    </div>

    <div class="flex gap-md pt-md">
        <a href="{{ route('membership-plans.index') }}" class="flex-1 py-md rounded-full border-2 border-primary text-primary font-bold text-center hover:bg-primary/5 transition-colors">Cancel</a>
        <button type="submit" class="flex-1 py-md rounded-full bg-primary text-on-primary font-bold hover:opacity-90 transition-opacity shadow-md">
            {{ $planModel ? 'Update Plan' : 'Create Plan' }}
        </button>
    </div>
</form>
