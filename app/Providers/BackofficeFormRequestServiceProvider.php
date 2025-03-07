<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Contracts\Requests\Backoffice as Contracts;
use App\Http\Requests\Backoffice as Requests;

class BackofficeFormRequestServiceProvider extends ServiceProvider
{
    public $singletons = [
        Contracts\StoreAdminRequestContract::class => Requests\StoreAdminRequest::class,
        Contracts\UpdateAdminRequestContract::class => Requests\UpdateAdminRequest::class,

        Contracts\UpdateAdminProfileRequestContract::class => Requests\UpdateAdminProfileRequest::class,
        Contracts\UpdateAdminPasswordRequestContract::class => Requests\UpdateAdminPasswordRequest::class,

        Contracts\StoreRoleRequestContract::class => Requests\StoreRoleRequest::class,
        Contracts\UpdateRoleRequestContract::class => Requests\UpdateRoleRequest::class,

        Contracts\StoreUserRequestContract::class => Requests\StoreUserRequest::class,
        Contracts\UpdateUserRequestContract::class => Requests\UpdateUserRequest::class,
        Contracts\UpdateUserActionLogRequestContract::class => Requests\UpdateUserActionLogRequest::class,
        Contracts\UpdateUserPasswordRequestContract::class => Requests\UpdateUserPasswordRequest::class,

        Contracts\UpdateSystemSettingRequestContract::class => Requests\UpdateSystemSettingRequest::class,
        Contracts\StoreSystemSettingGroupRequestContract::class => Requests\StoreSystemSettingGroupRequest::class,
        Contracts\StoreSystemSettingKeyRequestContract::class => Requests\StoreSystemSettingKeyRequest::class,
        Contracts\UpdateSystemSettingKeyRequestContract::class => Requests\UpdateSystemSettingKeyRequest::class,
        Contracts\ImportSystemSettingRequestContract::class => Requests\ImportSystemSettingRequest::class,
        Contracts\UpdateSystemSettingGroupRequestContract::class => Requests\UpdateSystemSettingGroupRequest::class,

        Contracts\StoreSystemCurrencyRequestContract::class => Requests\StoreSystemCurrencyRequest::class,
        Contracts\UpdateSystemCurrencyRequestContract::class => Requests\UpdateSystemCurrencyRequest::class,

        Contracts\StoreCategoryGroupRequestContract::class => Requests\StoreCategoryGroupRequest::class,
        Contracts\UpdateCategoryGroupRequestContract::class => Requests\UpdateCategoryGroupRequest::class,

        Contracts\StoreCategoryRequestContract::class => Requests\StoreCategoryRequest::class,
        Contracts\UpdateCategoryRequestContract::class => Requests\UpdateCategoryRequest::class,

        Contracts\StoreProductRequestContract::class => Requests\StoreProductRequest::class,
        Contracts\UpdateProductRequestContract::class => Requests\UpdateProductRequest::class,

        Contracts\StoreAttributeRequestContract::class => Requests\StoreAttributeRequest::class,
        Contracts\UpdateAttributeRequestContract::class => Requests\UpdateAttributeRequest::class,

        Contracts\StoreAttributeValueRequestContract::class => Requests\StoreAttributeValueRequest::class,
        Contracts\UpdateAttributeValueRequestContract::class => Requests\UpdateAttributeValueRequest::class,

        Contracts\StoreInventoryRequestContract::class => Requests\StoreInventoryRequest::class,
        Contracts\UpdateInventoryRequestContract::class => Requests\UpdateInventoryRequest::class,

        Contracts\StoreBannerRequestContract::class => Requests\StoreBannerRequest::class,
        Contracts\UpdateBannerRequestContract::class => Requests\UpdateBannerRequest::class,

        Contracts\StoreMenuGroupRequestContract::class => Requests\StoreMenuGroupRequest::class,
        Contracts\UpdateMenuGroupRequestContract::class => Requests\UpdateMenuGroupRequest::class,

        Contracts\StoreMenuSubGroupRequestContract::class => Requests\StoreMenuSubGroupRequest::class,
        Contracts\UpdateMenuSubGroupRequestContract::class => Requests\UpdateMenuSubGroupRequest::class,

        Contracts\StoreMenuRequestContract::class => Requests\StoreMenuRequest::class,
        Contracts\UpdateMenuRequestContract::class => Requests\UpdateMenuRequest::class,

        Contracts\StorePostCategoryRequestContract::class => Requests\StorePostCategoryRequest::class,
        Contracts\UpdatePostCategoryRequestContract::class => Requests\UpdatePostCategoryRequest::class,

        Contracts\StorePostRequestContract::class => Requests\StorePostRequest::class,
        Contracts\UpdatePostRequestContract::class => Requests\UpdatePostRequest::class,

        Contracts\StoreCollectionRequestContract::class => Requests\StoreCollectionRequest::class,
        Contracts\UpdateCollectionRequestContract::class => Requests\UpdateCollectionRequest::class,

        Contracts\StorePageRequestContract::class => Requests\StorePageRequest::class,
        Contracts\UpdatePageRequestContract::class => Requests\UpdatePageRequest::class,

        Contracts\StoreFaqTopicRequestContract::class => Requests\StoreFaqTopicRequest::class,
        Contracts\UpdateFaqTopicRequestContract::class => Requests\UpdateFaqTopicRequest::class,

        Contracts\StoreFaqRequestContract::class => Requests\StoreFaqRequest::class,
        Contracts\UpdateFaqRequestContract::class => Requests\UpdateFaqRequest::class,

        Contracts\StoreProductReviewRequestContract::class => Requests\StoreProductReviewRequest::class,
        Contracts\UpdateProductReviewRequestContract::class => Requests\UpdateProductReviewRequest::class,

        Contracts\StoreProductComboRequestContract::class => Requests\StoreProductComboRequest::class,
        Contracts\UpdateProductComboRequestContract::class => Requests\UpdateProductComboRequest::class,

        Contracts\UploadFileManagerRequestContract::class => Requests\UploadFileManagerRequest::class,

        Contracts\StoreShippingZoneRequestContract::class => Requests\StoreShippingZoneRequest::class,
        Contracts\UpdateShippingZoneRequestContract::class => Requests\UpdateShippingZoneRequest::class,

        Contracts\StoreShippingRateRequestContract::class => Requests\StoreShippingRateRequest::class,
        Contracts\UpdateShippingRateRequestContract::class => Requests\UpdateShippingRateRequest::class,

        Contracts\StoreShippingProviderRequestContract::class => Requests\StoreShippingProviderRequest::class,
        Contracts\UpdateShippingProviderRequestContract::class => Requests\UpdateShippingProviderRequest::class,

        Contracts\StoreShippingOptionRequestContract::class => Requests\StoreShippingOptionRequest::class,
        Contracts\UpdateShippingOptionRequestContract::class => Requests\UpdateShippingOptionRequest::class,

        Contracts\StorePaymentProviderRequestContract::class => Requests\StorePaymentProviderRequest::class,
        Contracts\UpdatePaymentProviderRequestContract::class => Requests\UpdatePaymentProviderRequest::class,

        Contracts\StorePaymentOptionRequestContract::class => Requests\StorePaymentOptionRequest::class,
        Contracts\UpdatePaymentOptionRequestContract::class => Requests\UpdatePaymentOptionRequest::class,

        Contracts\DeclineDepositTransactionRequestContract::class => Requests\DeclineDepositTransactionRequest::class,
        Contracts\ApproveDepositTransactionRequestContract::class => Requests\ApproveDepositTransactionRequest::class,

        Contracts\UpdateOrderStatusRequestContract::class => Requests\UpdateOrderStatusRequest::class,
        Contracts\StoreOrderRequestContract::class => Requests\StoreOrderRequest::class,

        Contracts\StoreHomePageDisplayOrderRequestContract::class => Requests\StoreHomePageDisplayOrderRequest::class,
        Contracts\UpdateHomePageDisplayOrderRequestContract::class => Requests\UpdateHomePageDisplayOrderRequest::class,
        Contracts\StoreHomePageDisplayItemRequestContract::class => Requests\StoreHomePageDisplayItemRequest::class,
        Contracts\UpdateHomePageDisplayItemRequestContract::class => Requests\UpdateHomePageDisplayItemRequest::class,

        Contracts\UpdateOrderShippingRequestContract::class => Requests\UpdateOrderShippingRequest::class,

        Contracts\StoreVideoCategoryRequestContract::class => Requests\StoreVideoCategoryRequest::class,
        Contracts\UpdateVideoCategoryRequestContract::class => Requests\UpdateVideoCategoryRequest::class,

        Contracts\StoreVideoRequestContract::class => Requests\StoreVideoRequest::class,
        Contracts\UpdateVideoRequestContract::class => Requests\UpdateVideoRequest::class,
    ];
}
