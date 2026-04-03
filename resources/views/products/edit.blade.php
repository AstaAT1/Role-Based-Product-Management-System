<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ __('Edit Product') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @include('products.partials.form', ['submitLabel' => 'Update Product'])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
