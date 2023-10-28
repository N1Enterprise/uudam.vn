<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend as Controllers;

Route::get('/', [Controllers\HomeController::class, 'index'])->name('home');

Route::get('products/{slug}', [Controllers\ProductController::class, 'index'])->name('products.index');

Route::get('my-cart', [Controllers\CartController::class, 'index']);

Route::get('blogs', [Controllers\BlogController::class, 'index']);

Route::get('blogs/posts/{slug}', [Controllers\PostController::class, 'index'])->name('posts.index');

Route::get('collections/{slug}', [Controllers\CollectionController::class, 'index'])->name('collections.index');

Route::get('pages/{slug}', [Controllers\PageController::class, 'index'])->name('pages.index');
