<?php

use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/products', [ProductController::class, 'index'])->name('web.products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('web.products.show');

    Route::post('/products/{product}/order', [OrderController::class, 'store'])->name('web.orders.store');

    Route::get('/my-orders', [OrderController::class, 'index'])->name('web.orders.index');
    Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('web.orders.show');

    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products.index');
    Route::get('/admin/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/admin/products/{product}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::put('/admin/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');

    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users.index');
    Route::get('/admin/users/{user}', [AdminController::class, 'showUser'])->name('admin.users.show');

    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
    Route::patch('/admin/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.status');
});
