@php
    $categoryModel = $category ?? null;
@endphp

<form
    method="POST"
    action="{{ $categoryModel ? route('categories.update', $categoryModel) : route('categories.store') }}"
    class="max-w-2xl bg-surface-container-lowest rounded-xl border border-outline-variant/20 shadow-sm p-md md:p-xl space-y-md"
>
    @csrf
    @if ($categoryModel)
        @method('PUT')
    @endif

    <div>
        <label for="name" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Category Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $categoryModel?->name) }}" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
    </div>

    <div>
        <label for="slug" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Slug</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug', $categoryModel?->slug) }}" required pattern="[a-z0-9]+(?:-[a-z0-9]+)*" class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
        <p class="text-label-sm text-on-surface-variant mt-xs">Lowercase URL identifier used on the shop page (e.g. <span class="font-mono">jellies</span>).</p>
    </div>

    <div>
        <label for="description" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Description</label>
        <textarea id="description" name="description" rows="3" class="w-full rounded-xl border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">{{ old('description', $categoryModel?->description) }}</textarea>
    </div>

    <div>
        <label for="sort_order" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Display Order</label>
        <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $categoryModel?->sort_order ?? 0) }}" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
    </div>

    <label class="flex items-center gap-sm text-label-md text-on-surface">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $categoryModel?->is_active ?? true)) class="rounded border-secondary text-primary focus:ring-primary">
        Active on website
    </label>

    <div class="flex gap-md pt-md">
        <a href="{{ route('categories.index') }}" class="flex-1 py-md rounded-full border-2 border-primary text-primary font-bold text-center hover:bg-primary/5 transition-colors">Cancel</a>
        <button type="submit" class="flex-1 py-md rounded-full bg-primary text-on-primary font-bold hover:opacity-90 transition-opacity shadow-md">
            {{ $categoryModel ? 'Update Category' : 'Create Category' }}
        </button>
    </div>
</form>
