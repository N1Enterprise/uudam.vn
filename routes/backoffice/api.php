<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backoffice\Api;

Route::prefix('v1')->group(function () {
    /* ======================== USER ======================== */
    Route::get('users', [Api\UserController::class, 'index'])->name('users.index')->middleware(['can:users.index']);

    /* ======================== ADMIN USERS ======================== */
    Route::get('admins', [Api\AdminController::class, 'index'])->name('admins.index')->middleware(['can:admins.index']);
    Route::put('my-profile', [Api\AdminController::class, 'updateCurrentUserProfile'])->name('admins.current.update-profile');
    Route::put('my-profile/change-password', [Api\AdminController::class, 'updateCurrentUserPassword'])->name('admins.current.change-password');

    Route::get('roles', [Api\RoleController::class, 'index'])->name('roles.index')->middleware(['can:roles.index']);

    /* ======================== SYSTEM ======================== */
    Route::post('system-settings/clear-cache', [Api\SystemSettingController::class, 'clearCache'])->name('system-settings.clear-cache')->middleware(['can:system-settings.clear-cache']);
    Route::post('system-settings/create-group', [Api\SystemSettingController::class, 'createGroup'])->name('system-settings.create-group')->middleware(['can:system-settings.store']);
    Route::post('system-settings/create-key', [Api\SystemSettingController::class, 'createKey'])->name('system-settings.create-key')->middleware(['can:system-settings.store']);
    Route::post('system-settings/import', [Api\SystemSettingController::class, 'import'])->name('system-settings.import')->middleware(['can:system-settings.import']);
    Route::put('system-settings/update-key', [Api\SystemSettingController::class, 'updateSettingKey'])->name('system-settings.update-key')->middleware(['can:system-settings.store']);
    Route::delete('system-settings/{id}', [Api\SystemSettingController::class, 'deleteSettingKey'])->name('system-settings.delete')->middleware(['can:system-settings.delete']);
    Route::delete('system-settings/{id}/group', [Api\SystemSettingController::class, 'deleteGroup'])->name('system-settings.delete.group')->middleware(['can:system-settings.delete']);
    Route::post('system-settings/{id}/group', [Api\SystemSettingController::class, 'updateGroup'])->name('system-settings.group.update')->middleware(['can:system-settings.update']);

    Route::get('system-currencies', [Api\SystemCurrencyController::class, 'index'])->name('system-currencies.index')->middleware(['can:system-currencies.manage']);
    Route::put('system-currencies/{key}/mark-as-default', [Api\SystemCurrencyController::class, 'markAsDefault'])->name('system-currencies.mark-as-default')->middleware(['can:system-currencies.manage']);
    Route::put('system-currencies/{key}/mark-as-base', [Api\SystemCurrencyController::class, 'markAsBase'])->name('system-currencies.mark-as-base')->middleware(['can:system-currencies.manage']);

    /* ======================== CATALOG ======================== */
    Route::get('category-groups', [Api\CategoryGroupController::class, 'index'])->name('category-groups.index')->middleware(['can:category-groups.index']);
    Route::get('categories', [Api\CategoryController::class, 'index'])->name('categories.index')->middleware(['can:categories.index']);
    Route::get('products', [Api\ProductController::class, 'index'])->name('products.index')->middleware(['can:products.index']);
    Route::get('attributes', [Api\AttributeController::class, 'index'])->name('attributes.index')->middleware(['can:attributes.index']);
    Route::get('attribute-values', [Api\AttributeValueController::class, 'index'])->name('attribute-values.index')->middleware(['can:attribute-values.index']);
    Route::get('product-combos', [Api\ProductComboController::class, 'index'])->name('product-combos.index')->middleware(['can:product-combos.index']);

    /* ======================== STOCK ======================== */
    Route::get('inventories', [Api\InventoryController::class, 'index'])->name('inventories.index')->middleware(['can:inventories.index']);

    /* ======================== SUPPORT DESKS ======================== */
    Route::get('product-reviews', [Api\ProductReviewController::class, 'index'])->name('product-reviews.index')->middleware(['can:product-reviews.index']);

    /* ======================== APPEARANCE ======================== */
    Route::get('display-inventories', [Api\DisplayInventoryController::class, 'index'])->name('display-inventories.index')->middleware(['can:display-inventories.index']);
    Route::get('home-page-display-orders', [Api\HomePageDisplayOrderController::class, 'index'])->name('home-page-display-orders.index')->middleware(['can:home-page-display-orders.index']);
    Route::get('banners', [Api\BannerController::class, 'index'])->name('banners.index')->middleware(['can:banners.index']);
    Route::get('menu-groups', [Api\MenuGroupController::class, 'index'])->name('menu-groups.index')->middleware(['can:menu-groups.index']);
    Route::get('menu-sub-groups', [Api\MenuSubGroupController::class, 'index'])->name('menu-sub-groups.index')->middleware(['can:menu-sub-groups.index']);
    Route::get('menus', [Api\MenuController::class, 'index'])->name('menus.index')->middleware(['can:menus.index']);

    /* ======================== UTILITIES ======================== */
    Route::get('post-categories', [Api\PostCategoryController::class, 'index'])->name('post-categories.index')->middleware(['can:post-categories.index']);
    Route::get('posts', [Api\PostController::class, 'index'])->name('posts.index')->middleware(['can:posts.index']);
    Route::get('collections', [Api\CollectionController::class, 'index'])->name('collections.index')->middleware(['can:collections.index']);
    Route::get('pages', [Api\PageController::class, 'index'])->name('pages.index')->middleware(['can:pages.index']);
    Route::get('faq-topics', [Api\FaqTopicController::class, 'index'])->name('faq-topics.index')->middleware(['can:faq-topics.index']);
    Route::get('faqs', [Api\FaqController::class, 'index'])->name('faqs.index')->middleware(['can:faqs.index']);

    /* ======================== SHIPPINGS ======================== */
    Route::get('carriers', [Api\CarrierController::class, 'index'])->name('carriers.index')->middleware(['can:carriers.index']);
    Route::get('shipping-zones', [Api\ShippingZoneController::class, 'index'])->name('shipping-zones.index')->middleware(['can:shipping-zones.index']);
    Route::get('shipping-rates', [Api\ShippingRateController::class, 'index'])->name('shipping-rates.index')->middleware(['can:shipping-rates.index']);

    /* ======================== LOCALIZATION ======================== */
    Route::get('countries', [Api\CountryController::class, 'index'])->name('countries.index')->middleware(['can:countries.index']);
    Route::get('currencies', [Api\CurrencyController::class, 'index'])->name('currencies.index')->middleware(['can:currencies.index']);

    /* ======================== PAYMENT ======================== */
    Route::get('payment-providers', [Api\PaymentProviderController::class, 'index'])->name('payment-providers.index')->middleware(['can:payment-providers.index']);
    Route::get('payment-options', [Api\PaymentOptionController::class, 'index'])->name('payment-options.index')->middleware(['can:payment-options.index']);

    Route::get('deposit-transactions', [Api\DepositTransactionController::class, 'index'])->name('deposit-transactions.index')->middleware(['can:deposit-transactions.index']);
    Route::put('deposit-transactions/{id}/decline', [Api\DepositTransactionController::class, 'decline'])->name('deposit-transactions.decline')->middleware(['can:deposit-transactions.update']);
    Route::put('deposit-transactions/{id}/approve', [Api\DepositTransactionController::class, 'approve'])->name('deposit-transactions.approve')->middleware(['can:deposit-transactions.update']);
    Route::get('deposit-transactions/statistic/status/{status}', [Api\DepositTransactionController::class, 'statisticStatus'])->name('deposit-transactions.statistic.status')->middleware(['can:deposit-transactions.index']);
    Route::get('deposit-transactions/statistic/amount', [Api\DepositTransactionController::class, 'statisticAmount'])->name('deposit-transactions.statistic.amount')->middleware(['can:deposit-transactions.index']);

    /* ======================== ORDER ======================== */
    Route::get('orders', [Api\OrderController::class, 'index'])->name('orders.index')->middleware(['can:orders.index']);
    Route::post('orders/{id}/change-status', [Api\OrderController::class, 'changeStatus'])->name('orders.change-status')->middleware('can:orders.manage');
    Route::get('orders/statistic/order-status/{orderStatus}', [Api\OrderController::class, 'statisticOrderStatus'])->name('orders.statistic.order-status')->middleware(['can:orders.index']);

    Route::get('order-items', [Api\OrderItemController::class, 'index'])->name('order-items.index')->middleware(['can:orders.index']);

    Route::get('carts', [Api\CartController::class, 'index'])->name('carts.index')->middleware(['can:carts.index']);
    Route::get('cart-items', [Api\CartItemController::class, 'index'])->name('cart-items.index')->middleware(['can:carts.index']);

    /* ======================== DASHBOARD REPORT ======================== */
    Route::get('dashboard/total-new-users', [Api\DashboardController::class, 'getTotalNewUsers'])->name('dashboard.new-users');
    Route::get('dashboard/total-new-orders', [Api\DashboardController::class, 'getTotalNewOrders'])->name('dashboard.new-orders');
    Route::get('dashboard/total-deposit', [Api\DashboardController::class, 'getTotalDeposit'])->name('dashboard.total-deposit');
    Route::get('dashboard/top-users', [Api\DashboardController::class, 'getTopUsers'])->name('dashboard.top-users');
    Route::get('dashboard/top-orders', [Api\DashboardController::class, 'getTopOrders'])->name('dashboard.top-orders');
});
