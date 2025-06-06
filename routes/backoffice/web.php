<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backoffice as Controllers;

Route::redirect('/', '/bo/dashboard');

Route::get('/dashboard', [Controllers\DashboardController::class, 'home'])->name('dashboard');

Route::get('users', [Controllers\UserController::class, 'index'])->name('users.index')->middleware(['can:users.index']);
Route::get('users/create', [Controllers\UserController::class, 'create'])->name('users.create')->middleware(['can:users.store']);
Route::post('users', [Controllers\UserController::class, 'store'])->name('users.store')->middleware(['can:users.store']);
Route::get('users/{id}', [Controllers\UserController::class, 'edit'])->name('users.edit')->middleware(['can:users.show']);
Route::put('users/{id}', [Controllers\UserController::class, 'update'])->name('users.update')->middleware(['can:users.update']);
Route::post('users/{id}/actions/deactivate', [Controllers\UserController::class, 'updateUserAction'])->name('users.action.deactivate')->middleware(['can:users.action']);
Route::post('users/{id}/actions/active', [Controllers\UserController::class, 'updateUserAction'])->name('users.action.active')->middleware(['can:users.action']);
Route::put('users/{id}/set-test-user', [Controllers\UserController::class, 'setTestUser'])->name('users.set-test-user')->middleware(['can:users.action']);
Route::put('users/{id}/update-password', [Controllers\UserController::class, 'updatePassword'])->name('users.update-password')->middleware(['can:users.change_password']);

/* ======================== ADMIN USER ======================== */
Route::get('admins', [Controllers\AdminController::class, 'index'])->name('admins.index');
Route::get('admins/create', [Controllers\AdminController::class, 'create'])->name('admins.create');
Route::post('admins', [Controllers\AdminController::class, 'store'])->name('admins.store');
Route::get('admins/{id}', [Controllers\AdminController::class, 'edit'])->name('admins.edit');
Route::put('admins/{id}', [Controllers\AdminController::class, 'update'])->name('admins.update');
Route::put('admins/{id}/active', [Controllers\AdminController::class, 'active'])->name('admins.active');
Route::put('admins/{id}/deactivate', [Controllers\AdminController::class, 'deactivate'])->name('admins.deactivate');

Route::get('roles', [Controllers\RoleController::class, 'index'])->name('roles.index');
Route::get('roles/create', [Controllers\RoleController::class, 'create'])->name('roles.create');
Route::post('roles', [Controllers\RoleController::class, 'store'])->name('roles.store');
Route::get('roles/{id}', [Controllers\RoleController::class, 'edit'])->name('roles.edit');
Route::put('roles/{id}', [Controllers\RoleController::class, 'update'])->name('roles.update');

/* ======================== SYSTEM ======================== */
Route::get('system-settings', [Controllers\SystemSettingController::class, 'index'])->name('system-settings.index')->middleware(['can:system-settings.index']);
Route::get('system-settings/{id}/edit', [Controllers\SystemSettingController::class, 'edit'])->name('system-settings.edit')->middleware(['can:system-settings.update']);
Route::post('system-settings/{id}/update', [Controllers\SystemSettingController::class, 'update'])->name('system-settings.update')->middleware(['can:system-settings.update']);

Route::get('system-currencies', [Controllers\SystemCurrencyController::class, 'index'])->name('system-currencies.index')->middleware(['can:system-currencies.manage']);
Route::get('system-currencies/create', [Controllers\SystemCurrencyController::class, 'create'])->name('system-currencies.create')->middleware(['can:system-currencies.manage']);
Route::post('system-currencies', [Controllers\SystemCurrencyController::class, 'store'])->name('system-currencies.store')->middleware(['can:system-currencies.manage']);
Route::get('system-currencies/{key}', [Controllers\SystemCurrencyController::class, 'edit'])->name('system-currencies.edit')->middleware(['can:system-currencies.manage']);
Route::put('system-currencies/{key}', [Controllers\SystemCurrencyController::class, 'update'])->name('system-currencies.update')->middleware(['can:system-currencies.manage']);

/* ======================== CATALOG ======================== */
Route::get('category-groups', [Controllers\CategoryGroupController::class, 'index'])->name('category-groups.index')->middleware(['can:category-groups.index']);
Route::get('category-groups/create', [Controllers\CategoryGroupController::class, 'create'])->name('category-groups.create')->middleware(['can:category-groups.store']);
Route::post('category-groups', [Controllers\CategoryGroupController::class, 'store'])->name('category-groups.store')->middleware(['can:category-groups.store']);
Route::get('category-groups/{id}', [Controllers\CategoryGroupController::class, 'edit'])->name('category-groups.edit')->middleware(['can:category-groups.update']);
Route::put('category-groups/{id}', [Controllers\CategoryGroupController::class, 'update'])->name('category-groups.update')->middleware(['can:category-groups.update']);

Route::get('categories', [Controllers\CategoryController::class, 'index'])->name('categories.index')->middleware(['can:categories.index']);
Route::get('categories/create', [Controllers\CategoryController::class, 'create'])->name('categories.create')->middleware(['can:categories.store']);
Route::post('categories', [Controllers\CategoryController::class, 'store'])->name('categories.store')->middleware(['can:categories.store']);
Route::get('categories/{id}', [Controllers\CategoryController::class, 'edit'])->name('categories.edit')->middleware(['can:categories.update']);
Route::put('categories/{id}', [Controllers\CategoryController::class, 'update'])->name('categories.update')->middleware(['can:categories.update']);

Route::get('products', [Controllers\ProductController::class, 'index'])->name('products.index')->middleware(['can:products.index']);
Route::get('products/create', [Controllers\ProductController::class, 'create'])->name('products.create')->middleware(['can:products.store']);
Route::post('products', [Controllers\ProductController::class, 'store'])->name('products.store')->middleware(['can:products.store']);
Route::get('products/{id}', [Controllers\ProductController::class, 'edit'])->name('products.edit')->middleware(['can:products.update']);
Route::put('products/{id}', [Controllers\ProductController::class, 'update'])->name('products.update')->middleware(['can:products.update']);

Route::get('attributes', [Controllers\AttributeController::class, 'index'])->name('attributes.index')->middleware(['can:attributes.index']);
Route::get('attributes/create', [Controllers\AttributeController::class, 'create'])->name('attributes.create')->middleware(['can:attributes.store']);
Route::post('attributes', [Controllers\AttributeController::class, 'store'])->name('attributes.store')->middleware(['can:attributes.store']);
Route::get('attributes/{id}', [Controllers\AttributeController::class, 'edit'])->name('attributes.edit')->middleware(['can:attributes.update']);
Route::put('attributes/{id}', [Controllers\AttributeController::class, 'update'])->name('attributes.update')->middleware(['can:attributes.update']);

Route::get('attribute-values', [Controllers\AttributeValueController::class, 'index'])->name('attribute-values.index')->middleware(['can:attribute-values.index']);
Route::get('attribute-values/create', [Controllers\AttributeValueController::class, 'create'])->name('attribute-values.create')->middleware(['can:attribute-values.store']);
Route::post('attribute-values', [Controllers\AttributeValueController::class, 'store'])->name('attribute-values.store')->middleware(['can:attribute-values.store']);
Route::get('attribute-values/{id}', [Controllers\AttributeValueController::class, 'edit'])->name('attribute-values.edit')->middleware(['can:attribute-values.update']);
Route::put('attribute-values/{id}', [Controllers\AttributeValueController::class, 'update'])->name('attribute-values.update')->middleware(['can:attribute-values.update']);
Route::delete('attribute-values/{id}', [Controllers\AttributeValueController::class, 'destroy'])->name('attribute-values.delete')->middleware(['can:attribute-values.delete']);

Route::get('inventories', [Controllers\InventoryController::class, 'index'])->name('inventories.index')->middleware(['can:inventories.index']);
Route::get('inventories/create', [Controllers\InventoryController::class, 'create'])->name('inventories.create')->middleware(['can:inventories.store']);
Route::post('inventories', [Controllers\InventoryController::class, 'store'])->name('inventories.store')->middleware(['can:inventories.store']);
Route::get('inventories/{id}', [Controllers\InventoryController::class, 'edit'])->name('inventories.edit')->middleware(['can:inventories.update']);
Route::put('inventories/{id}', [Controllers\InventoryController::class, 'update'])->name('inventories.update')->middleware(['can:inventories.update']);
Route::delete('inventories/{id}', [Controllers\InventoryController::class, 'destroy'])->name('inventories.delete')->middleware(['can:inventories.delete']);

Route::get('homepage-display-orders', [Controllers\HomePageDisplayOrderController::class, 'index'])->name('home-page-display-orders.index')->middleware(['can:home-page-display-orders.index']);
Route::get('homepage-display-orders/create', [Controllers\HomePageDisplayOrderController::class, 'create'])->name('home-page-display-orders.create')->middleware(['can:home-page-display-orders.store']);
Route::post('homepage-display-orders', [Controllers\HomePageDisplayOrderController::class, 'store'])->name('home-page-display-orders.store')->middleware(['can:home-page-display-orders.store']);
Route::get('homepage-display-orders/{id}', [Controllers\HomePageDisplayOrderController::class, 'edit'])->name('home-page-display-orders.edit')->middleware(['can:home-page-display-orders.update']);
Route::put('homepage-display-orders/{id}', [Controllers\HomePageDisplayOrderController::class, 'update'])->name('home-page-display-orders.update')->middleware(['can:home-page-display-orders.update']);
Route::delete('homepage-display-orders/{id}', [Controllers\HomePageDisplayOrderController::class, 'destroy'])->name('home-page-display-orders.delete')->middleware(['can:home-page-display-orders.delete']);

Route::get('homepage-display-items', [Controllers\HomePageDisplayItemController::class, 'index'])->name('home-page-display-items.index')->middleware(['can:home-page-display-items.index']);
Route::get('homepage-display-items/create', [Controllers\HomePageDisplayItemController::class, 'create'])->name('home-page-display-items.create')->middleware(['can:home-page-display-items.store']);
Route::post('homepage-display-items', [Controllers\HomePageDisplayItemController::class, 'store'])->name('home-page-display-items.store')->middleware(['can:home-page-display-items.store']);
Route::get('homepage-display-items/{id}', [Controllers\HomePageDisplayItemController::class, 'edit'])->name('home-page-display-items.edit')->middleware(['can:home-page-display-items.update']);
Route::put('homepage-display-items/{id}', [Controllers\HomePageDisplayItemController::class, 'update'])->name('home-page-display-items.update')->middleware(['can:home-page-display-items.update']);
Route::delete('homepage-display-items/{id}', [Controllers\HomePageDisplayItemController::class, 'destroy'])->name('home-page-display-items.delete')->middleware(['can:home-page-display-items.delete']);

Route::get('banners', [Controllers\BannerController::class, 'index'])->name('banners.index')->middleware(['can:banners.index']);
Route::get('banners/create', [Controllers\BannerController::class, 'create'])->name('banners.create')->middleware(['can:banners.store']);
Route::post('banners', [Controllers\BannerController::class, 'store'])->name('banners.store')->middleware(['can:banners.store']);
Route::get('banners/{id}', [Controllers\BannerController::class, 'edit'])->name('banners.edit')->middleware(['can:banners.update']);
Route::put('banners/{id}', [Controllers\BannerController::class, 'update'])->name('banners.update')->middleware(['can:banners.update']);
Route::delete('banners/{id}', [Controllers\BannerController::class, 'destroy'])->name('banners.delete')->middleware(['can:banners.delete']);

Route::get('menu-groups', [Controllers\MenuGroupController::class, 'index'])->name('menu-groups.index')->middleware(['can:menu-groups.index']);
Route::get('menu-groups/create', [Controllers\MenuGroupController::class, 'create'])->name('menu-groups.create')->middleware(['can:menu-groups.store']);
Route::post('menu-groups', [Controllers\MenuGroupController::class, 'store'])->name('menu-groups.store')->middleware(['can:menu-groups.store']);
Route::get('menu-groups/{id}', [Controllers\MenuGroupController::class, 'edit'])->name('menu-groups.edit')->middleware(['can:menu-groups.update']);
Route::put('menu-groups/{id}', [Controllers\MenuGroupController::class, 'update'])->name('menu-groups.update')->middleware(['can:menu-groups.update']);
Route::delete('menu-groups/{id}', [Controllers\MenuGroupController::class, 'destroy'])->name('menu-groups.delete')->middleware(['can:menu-groups.delete']);

Route::get('menu-sub-groups', [Controllers\MenuSubGroupController::class, 'index'])->name('menu-sub-groups.index')->middleware(['can:menu-sub-groups.index']);
Route::get('menu-sub-groups/create', [Controllers\MenuSubGroupController::class, 'create'])->name('menu-sub-groups.create')->middleware(['can:menu-sub-groups.store']);
Route::post('menu-sub-groups', [Controllers\MenuSubGroupController::class, 'store'])->name('menu-sub-groups.store')->middleware(['can:menu-sub-groups.store']);
Route::get('menu-sub-groups/{id}', [Controllers\MenuSubGroupController::class, 'edit'])->name('menu-sub-groups.edit')->middleware(['can:menu-sub-groups.update']);
Route::put('menu-sub-groups/{id}', [Controllers\MenuSubGroupController::class, 'update'])->name('menu-sub-groups.update')->middleware(['can:menu-sub-groups.update']);
Route::delete('menu-sub-groups/{id}', [Controllers\MenuSubGroupController::class, 'destroy'])->name('menu-sub-groups.delete')->middleware(['can:menu-sub-groups.delete']);

Route::get('menus', [Controllers\MenuController::class, 'index'])->name('menus.index')->middleware(['can:menus.index']);
Route::get('menus/create', [Controllers\MenuController::class, 'create'])->name('menus.create')->middleware(['can:menus.store']);
Route::post('menus', [Controllers\MenuController::class, 'store'])->name('menus.store')->middleware(['can:menus.store']);
Route::get('menus/{id}', [Controllers\MenuController::class, 'edit'])->name('menus.edit')->middleware(['can:menus.update']);
Route::put('menus/{id}', [Controllers\MenuController::class, 'update'])->name('menus.update')->middleware(['can:menus.update']);
Route::delete('menus/{id}', [Controllers\MenuController::class, 'destroy'])->name('menus.delete')->middleware(['can:menus.delete']);

Route::get('post-categories', [Controllers\PostCategoryController::class, 'index'])->name('post-categories.index')->middleware(['can:post-categories.index']);
Route::get('post-categories/create', [Controllers\PostCategoryController::class, 'create'])->name('post-categories.create')->middleware(['can:post-categories.store']);
Route::post('post-categories', [Controllers\PostCategoryController::class, 'store'])->name('post-categories.store')->middleware(['can:post-categories.store']);
Route::get('post-categories/{id}', [Controllers\PostCategoryController::class, 'edit'])->name('post-categories.edit')->middleware(['can:post-categories.update']);
Route::put('post-categories/{id}', [Controllers\PostCategoryController::class, 'update'])->name('post-categories.update')->middleware(['can:post-categories.update']);
Route::delete('post-categories/{id}', [Controllers\PostCategoryController::class, 'destroy'])->name('post-categories.delete')->middleware(['can:post-categories.delete']);

Route::get('posts', [Controllers\PostController::class, 'index'])->name('posts.index')->middleware(['can:posts.index']);
Route::get('posts/create', [Controllers\PostController::class, 'create'])->name('posts.create')->middleware(['can:posts.store']);
Route::post('posts', [Controllers\PostController::class, 'store'])->name('posts.store')->middleware(['can:posts.store']);
Route::get('posts/{id}', [Controllers\PostController::class, 'edit'])->name('posts.edit')->middleware(['can:posts.update']);
Route::put('posts/{id}', [Controllers\PostController::class, 'update'])->name('posts.update')->middleware(['can:posts.update']);
Route::delete('posts/{id}', [Controllers\PostController::class, 'destroy'])->name('posts.delete')->middleware(['can:posts.delete']);

Route::get('collections', [Controllers\CollectionController::class, 'index'])->name('collections.index')->middleware(['can:collections.index']);
Route::get('collections/create', [Controllers\CollectionController::class, 'create'])->name('collections.create')->middleware(['can:collections.store']);
Route::post('collections', [Controllers\CollectionController::class, 'store'])->name('collections.store')->middleware(['can:collections.store']);
Route::get('collections/{id}', [Controllers\CollectionController::class, 'edit'])->name('collections.edit')->middleware(['can:collections.update']);
Route::put('collections/{id}', [Controllers\CollectionController::class, 'update'])->name('collections.update')->middleware(['can:collections.update']);
Route::delete('collections/{id}', [Controllers\CollectionController::class, 'destroy'])->name('collections.delete')->middleware(['can:collections.delete']);

Route::get('pages', [Controllers\PageController::class, 'index'])->name('pages.index')->middleware(['can:pages.index']);
Route::get('pages/create', [Controllers\PageController::class, 'create'])->name('pages.create')->middleware(['can:pages.store']);
Route::post('pages', [Controllers\PageController::class, 'store'])->name('pages.store')->middleware(['can:pages.store']);
Route::get('pages/{id}', [Controllers\PageController::class, 'edit'])->name('pages.edit')->middleware(['can:pages.update']);
Route::put('pages/{id}', [Controllers\PageController::class, 'update'])->name('pages.update')->middleware(['can:pages.update']);
Route::delete('pages/{id}', [Controllers\PageController::class, 'destroy'])->name('pages.delete')->middleware(['can:pages.delete']);

Route::get('faq-topics', [Controllers\FaqTopicController::class, 'index'])->name('faq-topics.index')->middleware(['can:faq-topics.index']);
Route::get('faq-topics/create', [Controllers\FaqTopicController::class, 'create'])->name('faq-topics.create')->middleware(['can:faq-topics.store']);
Route::post('faq-topics', [Controllers\FaqTopicController::class, 'store'])->name('faq-topics.store')->middleware(['can:faq-topics.store']);
Route::get('faq-topics/{id}', [Controllers\FaqTopicController::class, 'edit'])->name('faq-topics.edit')->middleware(['can:faq-topics.update']);
Route::put('faq-topics/{id}', [Controllers\FaqTopicController::class, 'update'])->name('faq-topics.update')->middleware(['can:faq-topics.update']);
Route::delete('faq-topics/{id}', [Controllers\FaqTopicController::class, 'destroy'])->name('faq-topics.delete')->middleware(['can:faq-topics.delete']);

Route::get('faqs', [Controllers\FaqController::class, 'index'])->name('faqs.index')->middleware(['can:faqs.index']);
Route::get('faqs/create', [Controllers\FaqController::class, 'create'])->name('faqs.create')->middleware(['can:faqs.store']);
Route::post('faqs', [Controllers\FaqController::class, 'store'])->name('faqs.store')->middleware(['can:faqs.store']);
Route::get('faqs/{id}', [Controllers\FaqController::class, 'edit'])->name('faqs.edit')->middleware(['can:faqs.update']);
Route::put('faqs/{id}', [Controllers\FaqController::class, 'update'])->name('faqs.update')->middleware(['can:faqs.update']);
Route::delete('faqs/{id}', [Controllers\FaqController::class, 'destroy'])->name('faqs.delete')->middleware(['can:faqs.delete']);

Route::get('product-reviews', [Controllers\ProductReviewController::class, 'index'])->name('product-reviews.index')->middleware(['can:product-reviews.index']);
Route::get('product-reviews/create', [Controllers\ProductReviewController::class, 'create'])->name('product-reviews.create')->middleware(['can:product-reviews.store']);
Route::post('product-reviews', [Controllers\ProductReviewController::class, 'store'])->name('product-reviews.store')->middleware(['can:product-reviews.store']);
Route::get('product-reviews/{id}', [Controllers\ProductReviewController::class, 'edit'])->name('product-reviews.edit')->middleware(['can:product-reviews.update']);
Route::put('product-reviews/{id}', [Controllers\ProductReviewController::class, 'update'])->name('product-reviews.update')->middleware(['can:product-reviews.update']);
Route::delete('product-reviews/{id}', [Controllers\ProductReviewController::class, 'destroy'])->name('product-reviews.delete')->middleware(['can:product-reviews.delete']);

Route::get('product-combos', [Controllers\ProductComboController::class, 'index'])->name('product-combos.index')->middleware(['can:product-combos.index']);
Route::get('product-combos/create', [Controllers\ProductComboController::class, 'create'])->name('product-combos.create')->middleware(['can:product-combos.store']);
Route::post('product-combos', [Controllers\ProductComboController::class, 'store'])->name('product-combos.store')->middleware(['can:product-combos.store']);
Route::get('product-combos/{id}', [Controllers\ProductComboController::class, 'edit'])->name('product-combos.edit')->middleware(['can:product-combos.update']);
Route::put('product-combos/{id}', [Controllers\ProductComboController::class, 'update'])->name('product-combos.update')->middleware(['can:product-combos.update']);
Route::delete('product-combos/{id}', [Controllers\ProductComboController::class, 'destroy'])->name('product-combos.delete')->middleware(['can:product-combos.delete']);

Route::post('file-manager/upload', [Controllers\FileManagerController::class, 'upload'])->name('file-manager.upload');

Route::get('subscribers', [Controllers\SubscriberController::class, 'index'])->name('subscribers.index');

/* ======================== LOCALIZATION ======================== */
Route::get('countries', [Controllers\CountryController::class, 'index'])->name('countries.index')->middleware(['can:countries.index']);
Route::get('currencies', [Controllers\CurrencyController::class, 'index'])->name('currencies.index')->middleware(['can:currencies.index']);

/* ======================== SHIPPINGS ======================== */
Route::get('shipping-zones', [Controllers\ShippingZoneController::class, 'index'])->name('shipping-zones.index')->middleware(['can:shipping-zones.index']);
Route::get('shipping-zones/create', [Controllers\ShippingZoneController::class, 'create'])->name('shipping-zones.create')->middleware(['can:shipping-zones.store']);
Route::post('shipping-zones', [Controllers\ShippingZoneController::class, 'store'])->name('shipping-zones.store')->middleware(['can:shipping-zones.store']);
Route::get('shipping-zones/{id}', [Controllers\ShippingZoneController::class, 'edit'])->name('shipping-zones.edit')->middleware(['can:shipping-zones.update']);
Route::put('shipping-zones/{id}', [Controllers\ShippingZoneController::class, 'update'])->name('shipping-zones.update')->middleware(['can:shipping-zones.update']);

Route::get('shipping-rates', [Controllers\ShippingRateController::class, 'index'])->name('shipping-rates.index')->middleware(['can:shipping-rates.index']);
Route::get('shipping-rates/create', [Controllers\ShippingRateController::class, 'create'])->name('shipping-rates.create')->middleware(['can:shipping-rates.store']);
Route::post('shipping-rates', [Controllers\ShippingRateController::class, 'store'])->name('shipping-rates.store')->middleware(['can:shipping-rates.store']);
Route::get('shipping-rates/{id}', [Controllers\ShippingRateController::class, 'edit'])->name('shipping-rates.edit')->middleware(['can:shipping-rates.update']);
Route::put('shipping-rates/{id}', [Controllers\ShippingRateController::class, 'update'])->name('shipping-rates.update')->middleware(['can:shipping-rates.update']);
Route::delete('shipping-rates/{id}', [Controllers\ShippingRateController::class, 'destroy'])->name('shipping-rates.delete')->middleware(['can:shipping-rates.delete']);

Route::get('shipping-providers', [Controllers\ShippingProviderController::class, 'index'])->name('shipping-providers.index')->middleware(['can:shipping-providers.index']);
Route::get('shipping-providers/create', [Controllers\ShippingProviderController::class, 'create'])->name('shipping-providers.create')->middleware(['can:shipping-providers.store']);
Route::post('shipping-providers', [Controllers\ShippingProviderController::class, 'store'])->name('shipping-providers.store')->middleware(['can:shipping-providers.store']);
Route::get('shipping-providers/{id}', [Controllers\ShippingProviderController::class, 'edit'])->name('shipping-providers.edit')->middleware(['can:shipping-providers.update']);
Route::put('shipping-providers/{id}', [Controllers\ShippingProviderController::class, 'update'])->name('shipping-providers.update')->middleware(['can:shipping-providers.update']);

Route::get('shipping-options', [Controllers\ShippingOptionController::class, 'index'])->name('shipping-options.index')->middleware(['can:shipping-options.index']);
Route::get('shipping-options/create', [Controllers\ShippingOptionController::class, 'create'])->name('shipping-options.create')->middleware(['can:shipping-options.store']);
Route::post('shipping-options', [Controllers\ShippingOptionController::class, 'store'])->name('shipping-options.store')->middleware(['can:shipping-options.store']);
Route::get('shipping-options/{id}', [Controllers\ShippingOptionController::class, 'edit'])->name('shipping-options.edit')->middleware(['can:shipping-options.update']);
Route::put('shipping-options/{id}', [Controllers\ShippingOptionController::class, 'update'])->name('shipping-options.update')->middleware(['can:shipping-options.update']);

/* ======================== PAYMENT ======================== */
Route::get('payment-providers', [Controllers\PaymentProviderController::class, 'index'])->name('payment-providers.index')->middleware(['can:payment-providers.index']);
Route::get('payment-providers/create', [Controllers\PaymentProviderController::class, 'create'])->name('payment-providers.create')->middleware(['can:payment-providers.store']);
Route::post('payment-providers', [Controllers\PaymentProviderController::class, 'store'])->name('payment-providers.store')->middleware(['can:payment-providers.store']);
Route::get('payment-providers/{id}', [Controllers\PaymentProviderController::class, 'edit'])->name('payment-providers.edit')->middleware(['can:payment-providers.update']);
Route::put('payment-providers/{id}', [Controllers\PaymentProviderController::class, 'update'])->name('payment-providers.update')->middleware(['can:payment-providers.update']);

Route::get('payment-options', [Controllers\PaymentOptionController::class, 'index'])->name('payment-options.index')->middleware(['can:payment-options.index']);
Route::get('payment-options/create', [Controllers\PaymentOptionController::class, 'create'])->name('payment-options.create')->middleware(['can:payment-options.store']);
Route::post('payment-options', [Controllers\PaymentOptionController::class, 'store'])->name('payment-options.store')->middleware(['can:payment-options.store']);
Route::get('payment-options/{id}', [Controllers\PaymentOptionController::class, 'edit'])->name('payment-options.edit')->middleware(['can:payment-options.update']);
Route::put('payment-options/{id}', [Controllers\PaymentOptionController::class, 'update'])->name('payment-options.update')->middleware(['can:payment-options.update']);

Route::get('deposit-transactions', [Controllers\DepositTransactionController::class, 'index'])->name('deposit-transactions.index')->middleware(['can:deposit-transactions.index']);
Route::get('deposit-transactions/{id}', [Controllers\DepositTransactionController::class, 'edit'])->name('deposit-transactions.edit')->middleware(['can:deposit-transactions.update']);

/* ======================== ORDER ======================== */
Route::get('orders', [Controllers\OrderController::class, 'index'])->name('orders.index')->middleware(['can:orders.index']);
Route::get('orders/create', [Controllers\OrderController::class, 'create'])->name('orders.create')->middleware(['can:orders.manage']);
Route::post('orders', [Controllers\OrderController::class, 'store'])->name('orders.store')->middleware(['can:orders.manage']);
Route::get('orders/{id}', [Controllers\OrderController::class, 'edit'])->name('orders.edit')->middleware(['can:orders.manage']);

Route::get('carts', [Controllers\CartController::class, 'index'])->name('carts.index')->middleware(['can:carts.index']);
Route::get('carts/{id}', [Controllers\CartController::class, 'edit'])->name('carts.edit')->middleware(['can:carts.manage']);

Route::get('video-categories', [Controllers\VideoCategoryController::class, 'index'])->name('video-categories.index')->middleware(['can:video-categories.index']);
Route::get('video-categories/create', [Controllers\VideoCategoryController::class, 'create'])->name('video-categories.create')->middleware(['can:video-categories.store']);
Route::post('video-categories', [Controllers\VideoCategoryController::class, 'store'])->name('video-categories.store')->middleware(['can:video-categories.store']);
Route::get('video-categories/{id}', [Controllers\VideoCategoryController::class, 'edit'])->name('video-categories.edit')->middleware(['can:video-categories.update']);
Route::put('video-categories/{id}', [Controllers\VideoCategoryController::class, 'update'])->name('video-categories.update')->middleware(['can:video-categories.update']);
Route::delete('video-categories/{id}', [Controllers\VideoCategoryController::class, 'destroy'])->name('video-categories.delete')->middleware(['can:video-categories.delete']);

Route::get('videos', [Controllers\VideoController::class, 'index'])->name('videos.index')->middleware(['can:videos.index']);
Route::get('videos/create', [Controllers\VideoController::class, 'create'])->name('videos.create')->middleware(['can:videos.store']);
Route::post('videos', [Controllers\VideoController::class, 'store'])->name('videos.store')->middleware(['can:videos.store']);
Route::get('videos/{id}', [Controllers\VideoController::class, 'edit'])->name('videos.edit')->middleware(['can:videos.update']);
Route::put('videos/{id}', [Controllers\VideoController::class, 'update'])->name('videos.update')->middleware(['can:videos.update']);
Route::delete('videos/{id}', [Controllers\VideoController::class, 'destroy'])->name('videos.delete')->middleware(['can:videos.delete']);
