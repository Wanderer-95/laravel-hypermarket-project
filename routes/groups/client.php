<?php

use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\ProductController;

Route::name('client.')->group(function () {
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('categories/{category}/products', [CategoryController::class, 'productsIndex'])->name('categories.products.index');
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
});

