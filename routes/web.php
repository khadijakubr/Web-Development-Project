<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;


Route::get('/', function () {
    return redirect()->route('products');
});

// Products Routes
Route::prefix('products')->controller(ProductController::class)->group(function () {
    Route::get('/', 'index')->name('products');
    Route::get('/show/{id}', 'show')->name('products.show');
    
    // Admin routes (nanti bisa dikasih middleware admin)
    Route::get('/create', 'create')->name('products.create');
    Route::post('/store', 'store')->name('products.store');
    Route::get('/edit/{id}', 'edit')->name('products.edit');
    Route::post('/update/{id}', 'update')->name('products.update');
});

Route::middleware(['auth'])->group(function () {
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

// Auth Routes (dari Breeze)
require __DIR__.'/auth.php';
