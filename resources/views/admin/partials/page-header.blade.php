@props(['title', 'subtitle' => null, 'actionUrl' => null, 'actionLabel' => null])

<header class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-md mb-xl">
    <div>
        <h2 class="text-display-lg font-display-lg text-primary">{{ $title }}</h2>
        @if ($subtitle)
            <p class="text-body-lg text-on-surface-variant">{{ $subtitle }}</p>
        @endif
    </div>
    @if ($actionUrl && $actionLabel)
        <a
            href="{{ $actionUrl }}"
            class="inline-flex items-center gap-sm bg-primary text-on-primary px-md py-sm rounded-full font-label-md hover:scale-105 transition-transform shadow-sm shrink-0"
        >
            <span class="material-symbols-outlined">add</span>
            {{ $actionLabel }}
        </a>
    @endif
</header>
