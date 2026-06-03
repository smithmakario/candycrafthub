@php
    $productModel = $product ?? null;
@endphp

<form
    method="POST"
    action="{{ $productModel ? route('products.update', $productModel) : route('products.store') }}"
    enctype="multipart/form-data"
    class="max-w-2xl bg-surface-container-lowest rounded-xl border border-outline-variant/20 shadow-sm p-md md:p-xl space-y-md"
>
    @csrf
    @if ($productModel)
        @method('PUT')
    @endif

    <div>
        <label for="name" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Product Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $productModel?->name) }}" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
    </div>

    <div>
        <label for="sku" class="block text-label-md font-label-md mb-xs text-on-surface-variant">SKU</label>
        <input id="sku" name="sku" type="text" value="{{ old('sku', $productModel?->sku) }}" class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
    </div>

    <div>
        <label for="origin" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Origin</label>
        <select id="origin" name="origin" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
            @foreach ($origins as $origin)
                <option value="{{ $origin->value }}" @selected(old('origin', $productModel?->origin?->value) === $origin->value)>{{ $origin->label() }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="category" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Category</label>
        <input id="category" name="category" type="text" value="{{ old('category', $productModel?->category) }}" class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
    </div>

    <div>
        <label for="unit_price" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Unit Price (₦)</label>
        <input id="unit_price" name="unit_price" type="number" step="0.01" min="0" value="{{ old('unit_price', $productModel?->unit_price) }}" required class="w-full rounded-full border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">
    </div>

    <div>
        <label for="description" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Description</label>
        <textarea id="description" name="description" rows="4" class="w-full rounded-xl border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50">{{ old('description', $productModel?->description) }}</textarea>
    </div>

    <div>
        <label for="image" class="block text-label-md font-label-md mb-xs text-on-surface-variant">Product Image</label>
        @if ($productModel?->image_url)
            <div class="mb-sm flex items-start gap-md">
                <img src="{{ $productModel->image_url }}" alt="{{ $productModel->name }}" class="w-24 h-24 rounded-xl object-cover border border-outline-variant/20">
                <label class="flex items-center gap-sm text-label-sm text-on-surface-variant">
                    <input type="checkbox" name="remove_image" value="1" class="rounded border-secondary text-primary focus:ring-primary">
                    Remove current image
                </label>
            </div>
        @endif
        <input id="image" name="image" type="file" accept="image/*" class="w-full rounded-xl border-2 border-secondary focus:border-primary focus:ring-0 px-md py-sm bg-white/50 file:mr-md file:rounded-full file:border-0 file:bg-primary-container file:px-md file:py-xs file:text-primary file:font-label-md">
        <p class="text-label-sm text-on-surface-variant mt-xs">JPEG, PNG, or WebP up to 2MB.</p>
    </div>

    <label class="flex items-center gap-sm text-label-md text-on-surface">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $productModel?->is_active ?? true)) class="rounded border-secondary text-primary focus:ring-primary">
        Active product
    </label>

    <div class="flex gap-md pt-md">
        <a href="{{ route('products.index') }}" class="flex-1 py-md rounded-full border-2 border-primary text-primary font-bold text-center hover:bg-primary/5 transition-colors">Cancel</a>
        <button type="submit" class="flex-1 py-md rounded-full bg-primary text-on-primary font-bold hover:opacity-90 transition-opacity shadow-md">
            {{ $productModel ? 'Update Product' : 'Create Product' }}
        </button>
    </div>
</form>
