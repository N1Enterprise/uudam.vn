<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backoffice as Controllers;
use App\Http\Controllers\Frontend\UserAuthController;

Route::prefix('v1')->group(function() {
    Route::get('/ping', function() {
        return 'PONG';
    });

    Route::post('signup', [UserAuthController::class, 'signup'])->name('signup');
    Route::post('signin', [UserAuthController::class, 'signin'])->name('signin');
});
