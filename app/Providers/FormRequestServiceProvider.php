<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Contracts\Requests\Backoffice as BackofficeContracts;
use App\Http\Requests\Backoffice as BackofficeRequests;

class FormRequestServiceProvider extends ServiceProvider
{
    public $singletons = [
        BackofficeContracts\StoreAdminRequestContract::class => BackofficeRequests\StoreAdminRequest::class,
        BackofficeContracts\UpdateAdminRequestContract::class => BackofficeRequests\UpdateAdminRequest::class,
        BackofficeContracts\UpdateAdminProfileRequestContract::class => BackofficeRequests\UpdateAdminProfileRequest::class,
        BackofficeContracts\UpdateAdminPasswordRequestContract::class => BackofficeRequests\UpdateAdminPasswordRequest::class,
    ];
}
