<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;


Route::get('/', function () {
    return redirect()->route('products');
});

// Products Routes
Route::prefix('products')->controller(ProductController::class)->group(function () {
    Route::get('/', 'index')->name('products');
    Route::get('/show/{id}', 'show')->name('products.show');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Cart Routes
    Route::prefix('cart')->controller(CartController::class)->group(function () {
        Route::get('/', 'index')->name('cart.index');
        Route::post('/add', 'add')->name('cart.add');
        Route::post('/update/{id}', 'update')->name('cart.update');
        Route::delete('/remove/{id}', 'remove')->name('cart.remove');
    });
    
    // Checkout Routes
    Route::prefix('checkout')->controller(CheckoutController::class)->group(function () {
        Route::get('/', 'index')->name('checkout.index');
        Route::post('/process', 'process')->name('checkout.process');
    });
    
    // Order Routes
    Route::prefix('orders')->controller(OrderController::class)->group(function () {
        Route::get('/', 'index')->name('orders.index');
        Route::get('/show/{id}', 'show')->name('orders.show');
    });
    
});

Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('products', AdminProductController::class);

        Route::resource('categories', AdminCategoryController::class)
            ->only(['index', 'store', 'destroy']);

        Route::resource('orders', AdminOrderController::class)
            ->only(['index', 'show']);

        // USERS
        Route::get('users', [AdminUserController::class, 'index'])
            ->name('users.index');

        Route::put('users/{user}/role', [AdminUserController::class, 'updateRole'])
            ->name('users.updateRole');

        Route::delete('users/{user}', [AdminUserController::class, 'destroy'])
            ->name('users.destroy');

        // UPDATE ORDER STATUS
        Route::put('orders/{order}/status',
            [AdminOrderController::class, 'updateStatus']
        )->name('orders.updateStatus');
});

// Auth Routes (dari Breeze)
require __DIR__.'/auth.php';
