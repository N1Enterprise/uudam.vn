<?php

namespace App\Providers;

use App\Http\Responses\Backoffice as BackofficeResponses;
use App\Contracts\Responses\Backoffice as BackofficeContracts;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    public $singletons = [
        BackofficeContracts\StoreAdminResponseContract::class => BackofficeResponses\StoreAdminResponse::class,
        BackofficeContracts\UpdateAdminResponseContract::class => BackofficeResponses\UpdateAdminResponse::class,
        BackofficeContracts\ActiveAdminResponseContract::class => BackofficeResponses\ActiveAdminResponse::class,
        BackofficeContracts\DeactivateAdminResponseContract::class => BackofficeResponses\DeactivateAdminResponse::class,
        BackofficeContracts\ListAdminResponseContract::class => BackofficeResponses\ListAdminResponse::class,
        BackofficeContracts\StoreRoleResponseContract::class => BackofficeResponses\StoreRoleResponse::class,
        BackofficeContracts\UpdateRoleResponseContract::class => BackofficeResponses\UpdateRoleResponse::class,
        BackofficeContracts\ListRoleResponseContract::class => BackofficeResponses\ListRoleResponse::class,
        BackofficeContracts\UpdateUserResponseContract::class => BackofficeResponses\UpdateUserResponse::class,
        BackofficeContracts\ListUserResponseContract::class => BackofficeResponses\ListUserResponse::class,
        BackofficeContracts\UpdateSystemSettingResponseContract::class => BackofficeResponses\UpdateSystemSettingResponse::class,
        BackofficeContracts\ClearCacheSystemSettingResponseContract::class => BackofficeResponses\ClearCacheSystemSettingResponse::class,
        BackofficeContracts\StoreSystemSettingGroupResponseContract::class => BackofficeResponses\StoreSystemSettingGroupResponse::class,
        BackofficeContracts\DeleteSystemSettingGroupResponseContract::class => BackofficeResponses\DeleteSystemSettingGroupResponse::class,
        BackofficeContracts\StoreSystemSettingKeyResponseContract::class => BackofficeResponses\StoreSystemSettingKeyResponse::class,
        BackofficeContracts\DeleteSystemSettingKeyResponseContract::class => BackofficeResponses\DeleteSystemSettingKeyResponse::class,
        BackofficeContracts\ImportSystemSettingResponseContract::class => BackofficeResponses\ImportSystemSettingResponse::class,
        BackofficeContracts\UpdateSystemSettingGroupResponseContract::class => BackofficeResponses\UpdateSystemSettingGroupResponse::class,
    ];
}
