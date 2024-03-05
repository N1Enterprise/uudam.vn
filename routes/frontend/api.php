<?php

use App\Enum\SystemSettingKeyEnum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Api as Controllers;

// CATALOG
Route::post('user/subscribe/news-letter', [Controllers\UserSubscribeController::class, 'subscribeNewsLetter'])->name('user.subscribe.news-letter');
Route::get('user/collections/{id}/linked-inventories', [Controllers\CollectionController::class, 'getLinkedInventories'])->name('user.collections.linked-inventories');
Route::get('user/search/suggest', [Controllers\UserSearchController::class, 'suggest'])->name('user.search.suggest');
Route::get('user/search/inventories', [Controllers\UserSearchController::class, 'searchInventories'])->name('user.search.inventories');

// AUTHENTICATION
Route::post('user/signup', [Controllers\UserAuthenticationController::class, 'signup'])->name('user.signup');
Route::post('user/signin', [Controllers\UserAuthenticationController::class, 'signin'])->name('user.signin');
Route::post('user/signout', [Controllers\UserAuthenticationController::class, 'signout'])->name('user.signout');
Route::get('user/email/verify/{id}', [Controllers\UserAuthenticationController::class, 'verifyEmail'])->name('user.email_verification.verify')->middleware('system.feature_toggle:'.SystemSettingKeyEnum::ENABLE_USER_EMAIL_VERIFICATION);
Route::post('user/forgot-password', [Controllers\UserAuthenticationController::class, 'forgotPassword'])->name('user.forgot-password');
Route::put('user/reset-password', [Controllers\UserAuthenticationController::class, 'resetPassword'])->name('user.reset-password');

Route::get('user/oauth/providers', [Controllers\OauthController::class, 'providers'])->name('user.oauth.providers');
Route::get('user/oauth/{provider}/callback', [Controllers\OauthController::class, 'callback'])->name('user.oauth.callback');
Route::post('user/oauth/signin', [Controllers\OauthController::class, 'signin'])->name('user.oauth.signin');

Route::get('user/display-item/{id}/inventories', [Controllers\UserHomePageDisplayItemController::class, 'getInventories']);
Route::get('user/display-item/{id}/collections', [Controllers\UserHomePageDisplayItemController::class, 'getCollections']);
Route::get('user/display-item/{id}/posts', [Controllers\UserHomePageDisplayItemController::class, 'getPosts']);
Route::get('user/display-item/{id}/blogs', [Controllers\UserHomePageDisplayItemController::class, 'getBlogs']);

Route::get('localization/provinces', [Controllers\AddressController::class, 'getProvinces'])->name('localization.provinces');
Route::get('localization/{proviceCode}/districts', [Controllers\AddressController::class, 'getDistrictsByProvince'])->name('localization.districts-by-province');
Route::get('localization/{districtCode}/wards', [Controllers\AddressController::class, 'getWardsByDistrict'])->name('localization.wards-by-district');

Route::middleware(['auth:user'])->group(function() {
    // AUTHENTICATION
    Route::post('user/signout', [Controllers\UserAuthenticationController::class, 'signout'])->name('user.signout');
    Route::post('user/update-info', [Controllers\UserController::class, 'updateInfo'])->name('user.update-info');
    Route::post('user/update-password', [Controllers\UserController::class, 'updatePassword'])->name('user.update-password');

    // ORDER
    Route::post('user/order/{cartUuid}', [Controllers\UserOrderController::class, 'order'])->name('user.order.store');
    Route::post('user/order/reorder/{orderCode}', [Controllers\UserOrderController::class, 'reorder'])->name('user.order.reorder');
    Route::get('user/order/providers-shipping-rate', []);

    // CART
    Route::post('user/add-to-cart', [Controllers\UserCartController::class, 'store'])->name('user.cart.store');
    Route::get('user/carts-info', [Controllers\UserCartController::class, 'cartInfo'])->name('user.cart.info');
    Route::put('user/carts/{id}/delete', [Controllers\UserCartController::class, 'cancel'])->name('user.cart.delete');
    Route::put('user/carts/{id}/item-update-quantity', [Controllers\UserCartController::class, 'updateItemQuantity'])->name('user.cart-item.update-quantity');

    // SUPPORT DESKS
    Route::post('user/product/review', [Controllers\UserProductReviewController::class, 'review'])->name('user.product.review');

    // ADDRESS
    Route::post('user/localization/address', [Controllers\AddressController::class, 'store'])->name('user.address.store');
    Route::put('user/localization/address/{code}', [Controllers\AddressController::class, 'update'])->name('user.address.update');
    Route::get('user/localization/address/{code}', [Controllers\AddressController::class, 'show'])->name('user.localization.address.show');

    // Checkout
    Route::get('user/checkout/{cartUuid}/shipping-fee', [Controllers\UserCheckoutController::class, 'getShippingFee'])->name('user.checkout.provider-shipping-rate');
});
