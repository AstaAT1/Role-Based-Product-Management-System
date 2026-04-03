<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRoleRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $this->authorize('access admin dashboard');

        return view('admin.users.index', [
            'users' => User::query()
                ->with('roles')
                ->orderBy('name')
                ->paginate(12),
        ]);
    }

    public function edit(User $user): View
    {
        $this->authorize('access admin dashboard');

        return view('admin.users.edit', [
            'user' => $user->load('roles'),
            'roles' => ['Admin', 'Editor', 'Viewer'],
        ]);
    }

    public function update(UpdateUserRoleRequest $request, User $user): RedirectResponse
    {
        $this->authorize('access admin dashboard');

        $user->syncRoles([$request->validated('role')]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User role updated successfully.');
    }
}
