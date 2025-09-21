<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ParamController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGroupController;
use App\Http\Middleware\IsAdminMiddleware;

Route::get('dashboard', DashboardController::class)->prefix('admin')->name('dashboard')->middleware(['auth', IsAdminMiddleware::class]);
Route::prefix('admin')->name('admin.')->middleware(['auth', IsAdminMiddleware::class])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('params', ParamController::class);
    Route::resource('product-groups', ProductGroupController::class)->parameters(['product-groups' => 'productGroup']);
    Route::post('/products/{product}/replicate', [ProductController::class, 'replicate'])->name('products.replicate');
    Route::get('/products/{product}/children', [ProductController::class, 'indexChild'])->name('products.child.index');
    Route::delete('/product-image/{image}', [ProductController::class, 'productImage'])->name('product.image.destroy');
});
