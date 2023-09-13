<?php

namespace App\Providers;

use App\Http\Responses\Backoffice as BackofficeResponse;
use App\Contracts\Responses\Backoffice as BackofficeContracts;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    public $singletons = [
        BackofficeContracts\StoreAdminResponseContract::class => BackofficeResponse\StoreAdminResponse::class,
        BackofficeContracts\UpdateAdminResponseContract::class => BackofficeResponse\UpdateAdminResponse::class,
        BackofficeContracts\ActiveAdminResponseContract::class => BackofficeResponse\ActiveAdminResponse::class,
        BackofficeContracts\DeactivateAdminResponseContract::class => BackofficeResponse\DeactivateAdminResponse::class,
        BackofficeContracts\ListAdminResponseContract::class => BackofficeResponse\ListAdminResponse::class,
        BackofficeContracts\StoreRoleResponseContract::class => BackofficeResponse\StoreRoleResponse::class,
        BackofficeContracts\UpdateRoleResponseContract::class => BackofficeResponse\UpdateRoleResponse::class,
        BackofficeContracts\ListRoleResponseContract::class => BackofficeResponse\ListRoleResponse::class,
        BackofficeContracts\UpdateUserResponseContract::class => BackofficeResponse\UpdateUserResponse::class,
        BackofficeContracts\ListUserResponseContract::class => BackofficeResponse\ListUserResponse::class,
    ];
}
