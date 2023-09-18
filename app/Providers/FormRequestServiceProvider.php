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
        BackofficeContracts\StoreRoleRequestContract::class => BackofficeRequests\StoreRoleRequest::class,
        BackofficeContracts\UpdateRoleRequestContract::class => BackofficeRequests\UpdateRoleRequest::class,
        BackofficeContracts\UpdateUserRequestContract::class => BackofficeRequests\UpdateUserRequest::class,
        BackofficeContracts\UpdateSystemSettingRequestContract::class => BackofficeRequests\UpdateSystemSettingRequest::class,
        BackofficeContracts\StoreSystemSettingGroupRequestContract::class => BackofficeRequests\StoreSystemSettingGroupRequest::class,
        BackofficeContracts\StoreSystemSettingKeyRequestContract::class => BackofficeRequests\StoreSystemSettingKeyRequest::class,
        BackofficeContracts\UpdateSystemSettingKeyRequestContract::class => BackofficeRequests\UpdateSystemSettingKeyRequest::class,
        BackofficeContracts\ImportSystemSettingRequestContract::class => BackofficeRequests\ImportSystemSettingRequest::class,
        BackofficeContracts\UpdateSystemSettingGroupRequestContract::class => BackofficeRequests\UpdateSystemSettingGroupRequest::class,
        BackofficeContracts\StoreCategoryGroupRequestContract::class => BackofficeRequests\StoreCategoryGroupRequest::class,
        BackofficeContracts\UpdateCategoryGroupRequestContract::class => BackofficeRequests\UpdateCategoryGroupRequest::class,
        BackofficeContracts\StoreCategoryRequestContract::class => BackofficeRequests\StoreCategoryRequest::class,
        BackofficeContracts\UpdateCategoryRequestContract::class => BackofficeRequests\UpdateCategoryRequest::class,
        BackofficeContracts\StoreProductRequestContract::class => BackofficeRequests\StoreProductRequest::class,
        BackofficeContracts\UpdateProductRequestContract::class => BackofficeRequests\UpdateProductRequest::class,
        BackofficeContracts\StoreAttributeRequestContract::class => BackofficeRequests\StoreAttributeRequest::class,
        BackofficeContracts\UpdateAttributeRequestContract::class => BackofficeRequests\UpdateAttributeRequest::class,
    ];
}
