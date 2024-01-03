<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
// Route::get('/product', [ProductController::class, 'index'])->name('product.index');
// Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
// Route::post('/product', [ProductController::class, 'store'])->name('product.store');
// Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
// Route::patch('/product/{product}', [ProductController::class, 'update'])->name('product.update');

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResource('product', ProductController::class);
});


Route::post('/register', RegisterController::class)->name('user.register');
Route::post('/login', LoginController::class)->name('user.login');

