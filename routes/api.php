<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/categories', CategoryController::class);

Route::post('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');


//Login
Route::post('/login', [LoginController::class, 'login'])->name('login');
//Registration
Route::post('/register', RegisterController::class)->name('register');


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');

    Route::post('/logout', [LoginController::class, 'logout']);
});

