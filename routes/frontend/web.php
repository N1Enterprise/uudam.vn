<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend as Controllers;

Route::middleware(['feweb'])->group(function() {
    Route::redirect('/home', '/');
    Route::redirect('/index', '/');

    Route::get('/', [Controllers\HomeController::class, 'index'])->name('home');

    Route::get('san-pham/{slug}.html', [Controllers\ProductController::class, 'index'])->name('products.index');

    Route::get('bai-viet/{slug}.html', [Controllers\PostController::class, 'index'])->name('posts.index');

    Route::get('video/{slug}.html', [Controllers\VideoController::class, 'index'])->name('videos.index');

    Route::get('bo-suu-tap/{slug}.html', [Controllers\CollectionController::class, 'index'])->name('collections.index');

    Route::get('trang/{slug}.html', [Controllers\PageController::class, 'index'])->name('pages.index');

    Route::get('dang-bao-tri.html', [Controllers\MaintenanceController::class, 'index'])->name('maintenance');

    Route::get('tim-kiem.html', [Controllers\UserSearchController::class, 'index'])->name('search');

    Route::get('tin-tuc.html', [Controllers\NewsController::class, 'index'])->name('news.index');

    Route::get('tin-tuc/{slug}.html', [Controllers\NewsController::class, 'showPostCategory'])->name('news.show-post-categories');

    Route::middleware(['auth:user'])->group(function() {
        Route::get('gio-hang.html', [Controllers\UserCartController::class, 'index'])->name('cart.index');

        Route::get('hoan-thanh-ho-so.html', [Controllers\UserProfileController::class, 'profileComplete'])->name('user.complete-infomation');

        Route::get('ho-so.html', [Controllers\UserProfileController::class, 'account'])->name('user.profile');
        Route::get('mat-khau.html', [Controllers\UserProfileController::class, 'passwordChange'])->name('user.security.password-change');
        Route::get('lich-su-don-hang.html', [Controllers\UserOrderController::class, 'orderHistory'])->name('user.profile.order-histories');
        Route::get('lich-su-don-hang/{orderCode}.html', [Controllers\UserOrderController::class, 'orderHistoryDetail'])->name('user.profile.order-history-detail');
        Route::get('quan-ly-dia-chi.html', [Controllers\UserAddressController::class, 'address'])->name('user.localization.address');
        Route::get('cap-nhat-dia-chi/{code}.html', [Controllers\UserAddressController::class, 'edit'])->name('user.localization.address.edit');
        Route::get('them-dia-chi.html', [Controllers\UserAddressController::class, 'create'])->name('user.localization.address.create');

        Route::get('don-hang.html', [Controllers\UserCheckoutController::class, 'index'])->name('user.checkout.confirmation');
        Route::get('don-hang/{cartUuid}.html', [Controllers\UserCheckoutController::class, 'checkout'])->name('user.checkout.index');
        Route::get('thanh-toan-lai-don-hang/{orderCode}.html', [Controllers\UserCheckoutController::class, 'rePayment'])->name('user.checkout.repayment');

        Route::get('trang-thai-don-hang/{cartUuid}.html', [Controllers\UserCheckoutController::class, 'checkoutStatus'])->name('user.checkout.payment.status');
    });

    Route::get('/{code}.html', [Controllers\ShortenedLinkController::class, 'handleRedirect']);
});
