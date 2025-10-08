<?php

use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ProductController;

Route::name('client.')->group(function () {
    //Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('categories/{category}/products', [CategoryController::class, 'productsIndex'])->name('categories.products.index');
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');

    Route::resource('carts', CartController::class)->middleware('auth');
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('orders/{order}/transactions/create', [OrderController::class, 'createTransaction'])->name('orders.transactions.create');
});

