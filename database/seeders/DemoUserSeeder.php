<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            [
                'name' => 'asta',
                'email' => 'asta@gmail.com',
                'password' => 'zzzzzzzz',
                'role' => 'Admin',
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => 'password',
                'role' => 'Admin',
            ],
            [
                'name' => 'Editor User',
                'email' => 'editor@example.com',
                'password' => 'password',
                'role' => 'Editor',
            ],
            [
                'name' => 'Viewer User',
                'email' => 'viewer@example.com',
                'password' => 'password',
                'role' => 'Viewer',
            ],
        ] as $userData) {
            $user = User::query()
                ->whereRaw('LOWER(email) = ?', [strtolower($userData['email'])])
                ->first();

            if ($user === null) {
                $user = new User();
            }

            $user->forceFill([
                'name' => $userData['name'],
                'email' => strtolower($userData['email']),
                'password' => Hash::make($userData['password']),
                'email_verified_at' => now(),
            ])->save();

            $user->syncRoles([$userData['role']]);
        }
    }
}
