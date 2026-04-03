@csrf
<div class="space-y-6">
    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input
            id="name"
            name="name"
            type="text"
            class="mt-1 block w-full"
            :value="old('name', isset($product) ? $product->name : '')"
            required
            autofocus
        />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="description" :value="__('Description')" />
        <textarea
            id="description"
            name="description"
            rows="4"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        >{{ old('description', isset($product) ? $product->description : '') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="price" :value="__('Price')" />
        <x-text-input
            id="price"
            name="price"
            type="number"
            min="0"
            step="0.01"
            class="mt-1 block w-full"
            :value="old('price', isset($product) ? number_format((float) $product->price, 2, '.', '') : '')"
            required
        />
        <x-input-error :messages="$errors->get('price')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="image" :value="__('Product Image')" />
        <input
            id="image"
            name="image"
            type="file"
            accept="image/*"
            class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500"
        />
        <p class="mt-2 text-sm text-slate-500">Optional. Upload a JPG, PNG, WEBP, or GIF up to 2 MB.</p>
        <x-input-error :messages="$errors->get('image')" class="mt-2" />

        @if (! empty($product?->image))
            <div class="mt-4">
                <p class="mb-2 text-sm font-medium text-slate-600">Current image</p>
                <img
                    src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}"
                    alt="{{ $product->name }}"
                    class="h-40 w-full max-w-xs rounded-lg border border-slate-200 object-cover"
                />
            </div>
        @endif
    </div>

    <div class="flex items-center gap-3">
        <x-primary-button>{{ $submitLabel }}</x-primary-button>
        <a href="{{ route('products.index') }}" class="text-sm font-medium text-slate-600 transition hover:text-slate-900">
            Cancel
        </a>
    </div>
</div>
