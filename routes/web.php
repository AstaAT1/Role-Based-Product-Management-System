<?php

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'productCount' => Product::count(),
        'userCount' => User::count(),
    ]);
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])
        ->middleware('can:view products')
        ->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])
        ->middleware('can:create products')
        ->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])
        ->middleware('can:create products')
        ->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
        ->middleware('can:edit products')
        ->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])
        ->middleware('can:edit products')
        ->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])
        ->middleware('can:delete products')
        ->name('products.destroy');

    Route::get('/admin/users', [AdminUserController::class, 'index'])
        ->middleware('can:access admin dashboard')
        ->name('admin.users.index');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])
        ->middleware('can:access admin dashboard')
        ->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])
        ->middleware('can:access admin dashboard')
        ->name('admin.users.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/send-mail', [MailController::class, 'send']);
Route::get('/preview-mail', [MailController::class, 'preview']);

require __DIR__.'/auth.php';
