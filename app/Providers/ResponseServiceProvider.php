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
        BackofficeContracts\ListCategoryGroupResponseContract::class => BackofficeResponses\ListCategoryGroupResponse::class,
        BackofficeContracts\ListCategoryResponseContract::class => BackofficeResponses\ListCategoryResponse::class,
        BackofficeContracts\StoreCategoryGroupResponseContract::class => BackofficeResponses\StoreCategoryGroupResponse::class,
        BackofficeContracts\UpdateCategoryGroupResponseContract::class => BackofficeResponses\UpdateCategoryGroupResponse::class,
        BackofficeContracts\StoreCategoryResponseContract::class => BackofficeResponses\StoreCategoryResponse::class,
        BackofficeContracts\UpdateCategoryResponseContract::class => BackofficeResponses\UpdateCategoryResponse::class,
        BackofficeContracts\ListProductResponseContract::class => BackofficeResponses\ListProductResponse::class,
        BackofficeContracts\StoreProductResponseContract::class => BackofficeResponses\StoreProductResponse::class,
        BackofficeContracts\UpdateProductResponseContract::class => BackofficeResponses\UpdateProductResponse::class,
        BackofficeContracts\ListAttributeResponseContract::class => BackofficeResponses\ListAttributeResponse::class,
        BackofficeContracts\StoreAttributeResponseContract::class => BackofficeResponses\StoreAttributeResponse::class,
        BackofficeContracts\UpdateAttributeResponseContract::class => BackofficeResponses\UpdateAttributeResponse::class,
        BackofficeContracts\ListAttributeValueResponseContract::class => BackofficeResponses\ListAttributeValueResponse::class,
        BackofficeContracts\StoreAttributeValueResponseContract::class => BackofficeResponses\StoreAttributeValueResponse::class,
        BackofficeContracts\UpdateAttributeValueResponseContract::class => BackofficeResponses\UpdateAttributeValueResponse::class,
    ];
}
