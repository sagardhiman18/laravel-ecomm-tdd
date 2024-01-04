<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OrderController;
// Route::get('/product', [ProductController::class, 'index'])->name('product.index');
// Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
// Route::post('/product', [ProductController::class, 'store'])->name('product.store');
// Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
// Route::patch('/product/{product}', [ProductController::class, 'update'])->name('product.update');

Route::apiResource('product', ProductController::class);
Route::post('/register', RegisterController::class)->name('user.register');
Route::post('/login', LoginController::class)->name('user.login');

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/place-order', [OrderController::class, 'placeOrder']);
    Route::get('/order-history', [OrderController::class, 'orderHistory']);
    Route::patch('/update-order-status/{order}', [OrderController::class, 'updateOrderStatus']);
});



