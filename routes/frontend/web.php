<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend as Controllers;

Route::get('/', [Controllers\HomeController::class, 'index'])->name('home');

Route::get('products/{slug}', [Controllers\ProductController::class, 'index'])->name('products.index');

Route::get('blogs', [Controllers\BlogController::class, 'index']);

Route::get('blogs/posts/{slug}', [Controllers\PostController::class, 'index'])->name('posts.index');

Route::get('collections/{slug}', [Controllers\CollectionController::class, 'index'])->name('collections.index');

Route::get('pages/{slug}', [Controllers\PageController::class, 'index'])->name('pages.index');

Route::get('pages/{slug}', [Controllers\PageController::class, 'index'])->name('pages.index');

Route::get('maintenance', [Controllers\MaintenanceController::class, 'index'])->name('maintenance');

Route::middleware(['auth:user'])->group(function() {
    Route::get('cart', [Controllers\UserCartController::class, 'index'])->name('cart.index');
    Route::get('profile/info', [Controllers\UserProfileController::class, 'profile'])->name('user.profile.info');
    Route::get('profile/order-history', [Controllers\UserOrderController::class, 'orderHistory'])->name('user.profile.order-history');
    Route::get('profile/order-history/{orderCode}', [Controllers\UserOrderController::class, 'orderHistoryDetail'])->name('user.profile.order-history-detail');
    Route::get('profile/change-password', [Controllers\UserProfileController::class, 'changePassword'])->name('user.profile.change-password');

    Route::get('checkout-confirmation', [Controllers\UserCheckoutController::class, 'index'])->name('user.checkout.confirmation');
    Route::get('checkout/{cartUuid}', [Controllers\UserCheckoutController::class, 'checkout'])->name('user.checkout.index');
    Route::get('checkout/repayment/{orderCode}', [Controllers\UserCheckoutController::class, 'rePayment'])->name('user.checkout.repayment');

    Route::get('checkout/payment/failure/{orderCode}', [Controllers\UserCheckoutController::class, 'paymentFailure'])->name('user.checkout.payment.failure');
    Route::get('checkout/payment/success/{orderCode}', [Controllers\UserCheckoutController::class, 'paymentSuccess'])->name('user.checkout.payment.success');
});
