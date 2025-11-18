<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return redirect()->route('products');
});

Route::prefix('products')->controller(ProductController::class)->group(function () {
    Route::get('/', 'index')->name('products');                     // GET /products
    Route::get('/create', 'create')->name('products.create');       // GET /products/create
    Route::get('/edit/{id}', 'edit')->name('products.edit');        // GET /products/edit/{id}
    Route::post('/store', 'store')->name('products.store');         // POST /products/store
    Route::post('/update/{id}', 'update')->name('products.update'); // POST /products/update/{id}
    Route::get('/show/{id}', 'show')->name('products.show');        // GET /products/show/{id}
});
