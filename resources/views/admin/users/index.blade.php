<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ __('User Management') }}</h2>
                <p class="mt-1 text-sm text-slate-500">Admin-only role management for application users.</p>
            </div>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Current Role</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-700">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-700">{{ $user->getRoleNames()->first() ?? 'Unassigned' }}</td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="font-medium text-indigo-600 transition hover:text-indigo-800">
                                            Edit Role
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-slate-500">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-slate-200 px-6 py-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
