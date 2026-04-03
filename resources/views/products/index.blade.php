<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ __('Products') }}</h2>
                <p class="mt-1 text-sm text-slate-500">Browse and manage the product catalog.</p>
            </div>

            @can('create products')
                <a href="{{ route('products.create') }}" class="inline-flex items-center rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800">
                    Add Product
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                @if ($products->isEmpty())
                    <div class="p-8 text-center">
                        <h3 class="text-lg font-semibold text-slate-900">No products yet</h3>
                        <p class="mt-2 text-sm text-slate-600">Create the first product to get this catalog started.</p>

                        @can('create products')
                            <a href="{{ route('products.create') }}" class="mt-4 inline-flex items-center rounded-md bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-500">
                                Add Product
                            </a>
                        @endcan
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Image</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Price</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                @foreach ($products as $product)
                                    <tr class="align-top">
                                        <td class="px-6 py-4">
                                            @if ($product->image)
                                                <img
                                                    src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}"
                                                    alt="{{ $product->name }}"
                                                    class="h-16 w-16 rounded-lg border border-slate-200 object-cover"
                                                />
                                            @else
                                                <div class="flex h-16 w-16 items-center justify-center rounded-lg border border-dashed border-slate-300 bg-slate-50 text-xs text-slate-400">
                                                    No image
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-slate-900">{{ $product->name }}</div>
                                            <div class="mt-1 max-w-md text-sm text-slate-500">
                                                {{ \Illuminate\Support\Str::limit($product->description ?: 'No description provided.', 80) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-700">${{ number_format((float) $product->price, 2) }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-end gap-3 text-sm font-medium">
                                                @can('edit products')
                                                    <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 transition hover:text-indigo-800">
                                                        Edit
                                                    </a>
                                                @endcan

                                                @can('delete products')
                                                    <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Delete this product?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-rose-600 transition hover:text-rose-800">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="border-t border-slate-200 px-6 py-4">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
