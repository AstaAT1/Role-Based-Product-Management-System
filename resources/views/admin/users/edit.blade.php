<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ __('Edit User Role') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-slate-900">{{ $user->name }}</h3>
                    <p class="mt-1 text-sm text-slate-500">{{ $user->email }}</p>
                    <p class="mt-2 text-sm text-slate-600">
                        Current role: <span class="font-medium text-slate-900">{{ $user->getRoleNames()->first() ?? 'Unassigned' }}</span>
                    </p>
                </div>

                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="role" :value="__('Role')" />
                        <select
                            id="role"
                            name="role"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                            @foreach ($roles as $role)

                                       <option value="{{ $role }}" @selected(old('role', $user->getRoleNames()->first() ?? 'Viewer') === $role)>
                                    {{ $role }}
                                </option>


                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-3">
                        <x-primary-button>Update Role</x-primary-button>
                        <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-slate-600 transition hover:text-slate-900">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
