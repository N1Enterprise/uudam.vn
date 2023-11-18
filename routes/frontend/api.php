<?php

use App\Enum\SystemSettingKeyEnum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Api as Controllers;

Route::post('user/product/review', [Controllers\UserProductReviewController::class, 'review'])->name('user.product.review');
Route::post('user/subscribe/news-letter', [Controllers\UserSubscribeController::class, 'subscribeNewsLetter'])->name('user.subscribe.news-letter');
Route::get('user/collections/{id}/linked-inventories', [Controllers\CollectionController::class, 'getLinkedInventories'])->name('user.collections.linked-inventories');
Route::get('user/search/suggest', [Controllers\UserSearchController::class, 'suggest'])->name('user.search.suggest');

Route::post('user/signup', [Controllers\UserAuthenticationController::class, 'signup'])->name('user.signup');
Route::post('user/signin', [Controllers\UserAuthenticationController::class, 'signin'])->name('user.signin');
Route::post('user/signout', [Controllers\UserAuthenticationController::class, 'signout'])->name('user.signout');
Route::get('user/email/verify/{id}', [Controllers\UserAuthenticationController::class, 'verifyEmail'])->name('user.email_verification.verify')->middleware('system.feature_toggle:'.SystemSettingKeyEnum::ENABLE_USER_EMAIL_VERIFICATION);

Route::post('user/add-to-cart', [Controllers\UserCartController::class, 'store'])->name('user.cart.store');
Route::get('user/carts-info', [Controllers\UserCartController::class, 'cartInfo'])->name('user.cart.info');
Route::put('user/carts/{id}/delete', [Controllers\UserCartController::class, 'cancel'])->name('user.cart.delete');
Route::put('user/carts/{id}/item-update-quantity', [Controllers\UserCartController::class, 'updateItemQuantity'])->name('user.cart-item.update-quantity');
