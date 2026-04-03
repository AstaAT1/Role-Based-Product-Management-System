<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ $product->name }}</h2>
                <p class="mt-1 text-sm text-slate-500">Product details and inventory information.</p>
            </div>

            <div class="flex items-center gap-3">
                @can('edit products')
                    <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-500">
                        Edit
                    </a>
                @endcan

                @can('delete products')
                    <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center rounded-md bg-rose-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-rose-500">
                            Delete
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
                    <h3 class="text-lg font-semibold text-slate-900">Product Image</h3>

                    @if ($product->image)
                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}"
                            alt="{{ $product->name }}"
                            class="mt-4 h-80 w-full rounded-xl border border-slate-200 object-cover"
                        />
                    @else
                        <div class="mt-4 flex h-80 items-center justify-center rounded-xl border border-dashed border-slate-300 bg-slate-50 text-sm text-slate-500">
                            No product image uploaded.
                        </div>
                    @endif
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
                    <h3 class="text-lg font-semibold text-slate-900">Description</h3>
                    <p class="mt-4 whitespace-pre-line text-sm leading-7 text-slate-600">
                        {{ $product->description ?: 'No description provided.' }}
                    </p>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-900">Summary</h3>

                    <dl class="mt-4 space-y-4 text-sm">
                        <div>
                            <dt class="font-medium text-slate-500">Price</dt>
                            <dd class="mt-1 text-slate-900">${{ number_format((float) $product->price, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-500">Created By</dt>
                            <dd class="mt-1 text-slate-900">{{ $product->creator?->name ?? 'Unknown' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-500">Created</dt>
                            <dd class="mt-1 text-slate-900">{{ $product->created_at->format('M d, Y h:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-500">Last Updated</dt>
                            <dd class="mt-1 text-slate-900">{{ $product->updated_at->format('M d, Y h:i A') }}</dd>
                        </div>
                    </dl>

                    <a href="{{ route('products.index') }}" class="mt-6 inline-flex items-center text-sm font-medium text-slate-600 transition hover:text-slate-900">
                        Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
