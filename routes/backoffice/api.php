<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backoffice\Api;

Route::prefix('v1')->group(function () {
    /* ======================== ADMIN USERS ======================== */
    Route::get('admins', [Api\AdminController::class, 'index'])->name('admins.index')->middleware(['can:admins.index']);
    Route::put('my-profile', [Api\AdminController::class, 'updateCurrentUserProfile'])->name('admins.current.update-profile');
    Route::put('my-profile/change-password', [Api\AdminController::class, 'updateCurrentUserPassword'])->name('admins.current.change-password');

    Route::get('roles', [Api\RoleController::class, 'index'])->name('roles.index')->middleware(['can:roles.index']);
});
