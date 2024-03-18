<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend as Controllers;

Route::get('/', [Controllers\HomeController::class, 'index'])->name('home');

Route::get('products/{slug}', [Controllers\ProductController::class, 'index'])->name('products.index');

Route::get('blogs/{slug}', [Controllers\BlogController::class, 'index'])->name('blogs.index');

Route::get('posts/{slug}', [Controllers\PostController::class, 'index'])->name('posts.index');

Route::get('videos/{slug}', [Controllers\VideoController::class, 'index'])->name('videos.index');

Route::get('collections/{slug}', [Controllers\CollectionController::class, 'index'])->name('collections.index');

Route::get('pages/{slug}', [Controllers\PageController::class, 'index'])->name('pages.index');

Route::get('pages/{slug}', [Controllers\PageController::class, 'index'])->name('pages.index');

Route::get('maintenance', [Controllers\MaintenanceController::class, 'index'])->name('maintenance');

Route::get('search', [Controllers\UserSearchController::class, 'index'])->name('search');

Route::middleware(['auth:user'])->group(function() {
    Route::get('cart', [Controllers\UserCartController::class, 'index'])->name('cart.index');

    Route::get('profile', [Controllers\UserProfileController::class, 'account'])->name('user.profile');
    Route::get('security/password', [Controllers\UserProfileController::class, 'passwordChange'])->name('user.security.password-change');
    Route::get('sales/order/histories', [Controllers\UserOrderController::class, 'orderHistory'])->name('user.profile.order-histories');
    Route::get('sales/order/{orderCode}', [Controllers\UserOrderController::class, 'orderHistoryDetail'])->name('user.profile.order-history-detail');
    Route::get('localization/address', [Controllers\UserAddressController::class, 'address'])->name('user.localization.address');
    Route::get('localization/address/edit/{code}', [Controllers\UserAddressController::class, 'edit'])->name('user.localization.address.edit');
    Route::get('localization/address/create', [Controllers\UserAddressController::class, 'create'])->name('user.localization.address.create');

    Route::get('checkout-confirmation', [Controllers\UserCheckoutController::class, 'index'])->name('user.checkout.confirmation');
    Route::get('checkout/{cartUuid}', [Controllers\UserCheckoutController::class, 'checkout'])->name('user.checkout.index');
    Route::get('checkout/repayment/{orderCode}', [Controllers\UserCheckoutController::class, 'rePayment'])->name('user.checkout.repayment');

    Route::get('checkout/payment/failure/{orderCode}', [Controllers\UserCheckoutController::class, 'paymentFailure'])->name('user.checkout.payment.failure');
    Route::get('checkout/payment/success/{orderCode}', [Controllers\UserCheckoutController::class, 'paymentSuccess'])->name('user.checkout.payment.success');
});

Route::get('/zalo_verifierOTYN8wBvB1TvsFi8gSLu1LJLgJ-uetjaEJCq.html', function() {
    return view('frontend.3rd.zalo-dev-verify');
});
