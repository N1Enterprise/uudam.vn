<?php

use App\Http\Controllers\Payment\WebhookController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::any('callback/payment/{payment_provider}/{gameProviderParameter?}', [WebhookController::class, 'hook'])
        ->where('gameProviderParameter', '(.*)');
});
