<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backoffice as Controllers;

Route::get('/', [Controllers\DashboardController::class, 'home'])->name('dashboard');

Route::get('users', [Controllers\UserController::class, 'index'])->name('users.index')->middleware(['can:users.index']);
Route::get('users/{id}', [Controllers\UserController::class, 'edit'])->name('users.edit')->middleware(['can:users.show']);
Route::put('users/{id}', [Controllers\UserController::class, 'update'])->name('users.update')->middleware(['can:users.update']);
Route::post('users/{id}/actions/deactivate', [Controllers\UserController::class, 'updateUserAction'])->name('users.action.deactivate')->middleware(['can:users.action']);
Route::post('users/{id}/actions/active', [Controllers\UserController::class, 'updateUserAction'])->name('users.action.active')->middleware(['can:users.action']);

/* ======================== ADMIN USER ======================== */
Route::get('admins', [Controllers\AdminController::class, 'index'])->name('admins.index')->middleware(['can:admins.index']);
Route::get('admins/create', [Controllers\AdminController::class, 'create'])->name('admins.create')->middleware(['can:admins.store']);
Route::post('admins', [Controllers\AdminController::class, 'store'])->name('admins.store')->middleware(['can:admins.store']);
Route::get('admins/{id}', [Controllers\AdminController::class, 'edit'])->name('admins.edit')->middleware(['can:admins.update']);
Route::put('admins/{id}', [Controllers\AdminController::class, 'update'])->name('admins.update')->middleware(['can:admins.update']);
Route::put('admins/{id}/active', [Controllers\AdminController::class, 'active'])->name('admins.active')->middleware(['can:admins.update']);
Route::put('admins/{id}/deactivate', [Controllers\AdminController::class, 'deactivate'])->name('admins.deactivate')->middleware(['can:admins.update']);

Route::get('roles', [Controllers\RoleController::class, 'index'])->name('roles.index')->middleware(['can:roles.index']);
Route::get('roles/create', [Controllers\RoleController::class, 'create'])->name('roles.create')->middleware(['can:roles.store']);
Route::post('roles', [Controllers\RoleController::class, 'store'])->name('roles.store')->middleware(['can:roles.store']);
Route::get('roles/{id}', [Controllers\RoleController::class, 'edit'])->name('roles.edit')->middleware(['can:roles.update']);
Route::put('roles/{id}', [Controllers\RoleController::class, 'update'])->name('roles.update')->middleware(['can:roles.update']);

/* ======================== SYSTEM ======================== */
Route::get('system-settings', [Controllers\SystemSettingController::class, 'index'])->name('system-settings.index')->middleware(['can:system-settings.index']);
Route::get('system-settings/{id}/edit', [Controllers\SystemSettingController::class, 'edit'])->name('system-settings.edit')->middleware(['can:system-settings.update']);
Route::post('system-settings/{id}/update', [Controllers\SystemSettingController::class, 'update'])->name('system-settings.update')->middleware(['can:system-settings.update']);

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
