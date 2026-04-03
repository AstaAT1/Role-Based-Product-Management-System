<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $asta = User::query()->where('email', 'asta@gmail.com')->first();
        $admin = User::query()->where('email', 'admin@example.com')->first();
        $editor = User::query()->where('email', 'editor@example.com')->first();
        $fallbackUser = $asta ?? $admin ?? $editor ?? User::query()->first();

        foreach ([
            [
                'name' => 'Office Chair',
                'description' => 'Ergonomic chair with lumbar support for long work sessions.',
                'price' => 149.99,
                'created_by' => $asta?->id ?? $fallbackUser?->id,
            ],
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'Compact mechanical keyboard with tactile switches and white backlight.',
                'price' => 89.50,
                'created_by' => $editor?->id ?? $fallbackUser?->id,
            ],
            [
                'name' => 'USB-C Monitor',
                'description' => '27-inch display with USB-C connectivity and adjustable stand.',
                'price' => 329.00,
                'created_by' => $admin?->id ?? $fallbackUser?->id,
            ],
        ] as $product) {
            Product::query()->updateOrCreate(
                ['name' => $product['name']],
                $product,
            );
        }
    }
}
