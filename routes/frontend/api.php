<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Api as Controllers;

Route::post('user/product/review', [Controllers\UserProductReviewController::class, 'review'])->name('user.product.review');
