@php
    $categoryName = $product->category?->name;

    $profileContainerClass = match ($categoryName) {
        'Chocolate' => 'bg-primary-container/20',
        'Nostalgic Classics' => 'bg-tertiary-container/30',
        default => 'bg-secondary-container/30',
    };

    $profileLabelClass = match ($categoryName) {
        'Chocolate' => 'text-primary',
        'Nostalgic Classics' => 'text-tertiary',
        default => 'text-secondary',
    };

    $profileTextClass = match ($categoryName) {
        'Chocolate' => 'text-on-primary-container',
        'Nostalgic Classics' => 'text-on-tertiary-container',
        default => 'text-on-secondary-container',
    };

    $badgeClass = match ($product->badge) {
        'New Arrival' => 'bg-secondary text-on-secondary',
        default => 'bg-tertiary-container text-on-tertiary-container',
    };
@endphp

<div
    class="group bg-surface-container-lowest rounded-xl p-md border border-outline-variant/20 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col">
    <div class="relative rounded-lg overflow-hidden mb-md aspect-square">
        @if ($product->image_url)
            <img alt="{{ $product->name }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                src="{{ $product->image_url }}" />
        @else
            <div
                class="w-full h-full bg-surface-container flex items-center justify-center text-on-surface-variant font-label-md">
                No image
            </div>
        @endif
        @if ($product->badge)
            <span
                class="absolute top-2 right-2 {{ $badgeClass }} font-label-sm text-label-sm px-sm py-xs rounded-full">{{ $product->badge }}</span>
        @endif
    </div>
    <h4 class="font-headline-sm text-headline-sm text-on-surface mb-xs">{{ $product->name }}</h4>
    <div class="flex-grow">
        @if ($product->taste_profile)
            <div class="mb-sm p-sm {{ $profileContainerClass }} rounded-lg">
                <p class="font-label-md text-label-md {{ $profileLabelClass }} font-bold">Taste Profile</p>
                <p class="font-body-md text-body-md {{ $profileTextClass }}">{{ $product->taste_profile }}</p>
            </div>
        @endif
        @if ($product->memory_quote)
            <div class="mb-md italic text-on-surface-variant flex items-start gap-xs">
                <span class="material-symbols-outlined text-primary text-sm" data-icon="history_edu">history_edu</span>
                <p class="font-body-md text-body-md">"{{ $product->memory_quote }}"</p>
            </div>
        @endif
    </div>
    <div class="flex items-center justify-between pt-md border-t border-outline-variant/10">
        <span class="font-headline-sm text-headline-sm text-primary">{{ $product->formattedPrice() }}</span>
        <form method="POST" action="{{ route('cart.store', $product) }}">
            @csrf
            <input type="hidden" name="quantity" value="1">
            <button type="submit"
                class="bg-primary text-on-primary px-md py-sm rounded-full font-label-md text-label-md hover:scale-105 active:scale-95 transition-all duration-200">
                Add to Cart
            </button>
        </form>
    </div>
</div>
