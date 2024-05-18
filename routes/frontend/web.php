<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend as Controllers;

Route::middleware(['feweb'])->group(function() {
    Route::redirect('/home', '/');
    Route::redirect('/index', '/');

    Route::get('/', [Controllers\HomeController::class, 'index'])->name('home');

    Route::get('san-pham/{slug}', [Controllers\ProductController::class, 'index'])->name('products.index');

    Route::get('bai-viet/{slug}', [Controllers\PostController::class, 'index'])->name('posts.index');

    Route::get('video/{slug}', [Controllers\VideoController::class, 'index'])->name('videos.index');

    Route::get('bo-suu-tap/{slug}', [Controllers\CollectionController::class, 'index'])->name('collections.index');

    Route::get('trang/{slug}', [Controllers\PageController::class, 'index'])->name('pages.index');

    Route::get('dang-bao-tri', [Controllers\MaintenanceController::class, 'index'])->name('maintenance');

    Route::get('tim-kiem', [Controllers\UserSearchController::class, 'index'])->name('search');

    Route::get('tin-tuc', [Controllers\NewsController::class, 'index'])->name('news.index');

    Route::get('tin-tuc/{slug}', [Controllers\NewsController::class, 'showPostCategory'])->name('news.show-post-categories');

    Route::middleware(['auth:user'])->group(function() {
        Route::get('gio-hang', [Controllers\UserCartController::class, 'index'])->name('cart.index');

        Route::get('hoan-thanh-ho-so', [Controllers\UserProfileController::class, 'profileComplete'])->name('user.complete-infomation');

        Route::get('ho-so', [Controllers\UserProfileController::class, 'account'])->name('user.profile');
        Route::get('mat-khau', [Controllers\UserProfileController::class, 'passwordChange'])->name('user.security.password-change');
        Route::get('lich-su-don-hang', [Controllers\UserOrderController::class, 'orderHistory'])->name('user.profile.order-histories');
        Route::get('lich-su-don-hang/{orderCode}', [Controllers\UserOrderController::class, 'orderHistoryDetail'])->name('user.profile.order-history-detail');
        Route::get('quan-ly-dia-chi', [Controllers\UserAddressController::class, 'address'])->name('user.localization.address');
        Route::get('cap-nhat-dia-chi/{code}', [Controllers\UserAddressController::class, 'edit'])->name('user.localization.address.edit');
        Route::get('them-dia-chi', [Controllers\UserAddressController::class, 'create'])->name('user.localization.address.create');

        Route::get('xac-nhan-don-hang', [Controllers\UserCheckoutController::class, 'index'])->name('user.checkout.confirmation');
        Route::get('xac-nhan-don-hang/{cartUuid}', [Controllers\UserCheckoutController::class, 'checkout'])->name('user.checkout.index');
        Route::get('thanh-toan-lai-don-hang/{orderCode}', [Controllers\UserCheckoutController::class, 'rePayment'])->name('user.checkout.repayment');

        Route::get('trang-thai-don-hang/{cartUuid}', [Controllers\UserCheckoutController::class, 'checkoutStatus'])->name('user.checkout.payment.status');
    });

    Route::get('/{code}', [Controllers\ShortenedLinkController::class, 'handleRedirect']);
});
