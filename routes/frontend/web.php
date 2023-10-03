<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend as Controllers;
use App\Http\Controllers\Frontend\UserAuthController;

Route::get('/', [Controllers\HomeController::class, 'index'])->name('home');

Route::get('products/{slug}', [Controllers\ProductController::class, 'index']);

Route::get('my-cart', [Controllers\CartController::class, 'index']);

Route::get('blogs', [Controllers\BlogController::class, 'index']);

Route::get('blogs/news/{slug}', [Controllers\BlogNewsController::class, 'index']);

Route::get('collections/{slug}', [Controllers\CollectionController::class, 'index']);

Route::get('email/verify/{id}', [UserAuthController::class, 'verifyEmail'])->name('email_verification.verify');
