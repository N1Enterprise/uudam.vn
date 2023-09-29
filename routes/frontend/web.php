<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend as Controllers;

Route::get('/', [Controllers\HomeController::class, 'index'])->name('home');

Route::get('products/{slug}', [Controllers\ProductController::class, 'index']);

Route::get('my-cart', [Controllers\CartController::class, 'index']);
