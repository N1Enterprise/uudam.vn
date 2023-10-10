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

    /* ======================== CATALOG ======================== */
    Route::get('category-groups', [Api\CategoryGroupController::class, 'index'])->name('category-groups.index')->middleware(['can:category-groups.index']);
    Route::get('categories', [Api\CategoryController::class, 'index'])->name('categories.index')->middleware(['can:categories.index']);
    Route::get('products', [Api\ProductController::class, 'index'])->name('products.index')->middleware(['can:products.index']);
    Route::get('attributes', [Api\AttributeController::class, 'index'])->name('attributes.index')->middleware(['can:attributes.index']);
    Route::get('attribute-values', [Api\AttributeValueController::class, 'index'])->name('attribute-values.index')->middleware(['can:attribute-values.index']);

    /* ======================== STOCK ======================== */
    Route::get('inventories', [Api\InventoryController::class, 'index'])->name('inventories.index')->middleware(['can:inventories.index']);

    /* ======================== APPEARANCE ======================== */
    Route::get('display-inventories', [Api\DisplayInventoryController::class, 'index'])->name('display-inventories.index')->middleware(['can:display-inventories.index']);
    Route::get('banners', [Api\BannerController::class, 'index'])->name('banners.index')->middleware(['can:banners.index']);
    Route::get('menu-groups', [Api\MenuGroupController::class, 'index'])->name('menu-groups.index')->middleware(['can:menu-groups.index']);
    Route::get('menu-sub-groups', [Api\MenuSubGroupController::class, 'index'])->name('menu-sub-groups.index')->middleware(['can:menu-sub-groups.index']);
    Route::get('menus', [Api\MenuController::class, 'index'])->name('menus.index')->middleware(['can:menus.index']);

    /* ======================== UTILITIES ======================== */
    Route::get('post-categories', [Api\PostCategoryController::class, 'index'])->name('post-categories.index')->middleware(['can:post-categories.index']);
    Route::get('posts', [Api\PostController::class, 'index'])->name('posts.index')->middleware(['can:posts.index']);
});
