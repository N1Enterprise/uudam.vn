<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend as Controllers;

Route::get('/', [Controllers\HomeController::class, 'index'])->name('home');

Route::get('products/{slug}', [Controllers\ProductController::class, 'index'])->name('products.show');

Route::get('my-cart', [Controllers\CartController::class, 'index']);

Route::get('blogs', [Controllers\BlogController::class, 'index']);

Route::get('blogs/news/{slug}', [Controllers\BlogNewsController::class, 'index'])->name('posts.show');

Route::get('collections/{slug}', [Controllers\CollectionController::class, 'index']);
