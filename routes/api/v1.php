<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
})->name('auth:me');

/*
 * Product Routes
 */

Route::prefix('products')->as('products:')->group(function () {
    /**
     * List all products
     */
    Route::get(
        '/',
        App\Http\Controllers\Api\V1\Products\IndexController::class
    )->name('index');

    /**
     * Show all products
     */
    Route::get(
        '{key}',
        App\Http\Controllers\Api\V1\Products\ShowController::class
    )->name('show');
});

/**
 * Cart Routes
 */
Route::prefix('carts')->as('carts:')->group(function () {
    /**
     * Get the users cart
     */
    Route::get('/', App\Http\Controllers\Api\V1\Carts\IndexController::class)->name('index');

    /**
     * create new cart
     */
    Route::post('/', App\Http\Controllers\Api\V1\Carts\StoreController::class)->name('store');

    /**
     * Add a product to the  cart
     */
    Route::post('{cart:uuid}/products', App\Http\Controllers\Api\V1\Carts\Products\StoreController::class)->name('products:store');
    /**
     * update Quantity
     */
    Route::patch('{cart:uuid}/products/{item:uuid}', App\Http\Controllers\Api\V1\Carts\products\UpdateController::class)->name('products:update');
    /**
     * Delete Product from the cart
     */
    Route::delete('{cart:uuid}/products/{item:uuid}', App\Http\Controllers\Api\V1\Carts\products\DeleteController::class)->name('products:delete');
});
