<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Api as Controllers;
use App\Http\Controllers\Frontend\Api\UserSearchController;

Route::post('user/product/review', [Controllers\UserProductReviewController::class, 'review'])->name('user.product.review');
Route::post('user/subscribe/news-letter', [Controllers\UserSubscribeController::class, 'subscribeNewsLetter'])->name('user.subscribe.news-letter');
Route::get('user/collections/{id}/linked-inventories', [Controllers\CollectionController::class, 'getLinkedInventories'])->name('user.collections.linked-inventories');
Route::get('user/search/suggest', [UserSearchController::class, 'suggest'])->name('user.search.suggest');
