<?php

namespace App\Providers;

use App\Http\Responses\Backoffice as Responses;
use App\Contracts\Responses\Backoffice as Contracts;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class BackofficeResponseServiceProvider extends ServiceProvider
{
    public $singletons = [
        Contracts\StoreAdminResponseContract::class => Responses\StoreAdminResponse::class,
        Contracts\UpdateAdminResponseContract::class => Responses\UpdateAdminResponse::class,
        Contracts\ActiveAdminResponseContract::class => Responses\ActiveAdminResponse::class,
        Contracts\DeactivateAdminResponseContract::class => Responses\DeactivateAdminResponse::class,
        Contracts\ListAdminResponseContract::class => Responses\ListAdminResponse::class,

        Contracts\StoreRoleResponseContract::class => Responses\StoreRoleResponse::class,
        Contracts\UpdateRoleResponseContract::class => Responses\UpdateRoleResponse::class,
        Contracts\ListRoleResponseContract::class => Responses\ListRoleResponse::class,

        Contracts\UpdateUserResponseContract::class => Responses\UpdateUserResponse::class,
        Contracts\ListUserResponseContract::class => Responses\ListUserResponse::class,

        Contracts\UpdateSystemSettingResponseContract::class => Responses\UpdateSystemSettingResponse::class,
        Contracts\ClearCacheSystemSettingResponseContract::class => Responses\ClearCacheSystemSettingResponse::class,
        Contracts\StoreSystemSettingGroupResponseContract::class => Responses\StoreSystemSettingGroupResponse::class,
        Contracts\DeleteSystemSettingGroupResponseContract::class => Responses\DeleteSystemSettingGroupResponse::class,
        Contracts\StoreSystemSettingKeyResponseContract::class => Responses\StoreSystemSettingKeyResponse::class,
        Contracts\DeleteSystemSettingKeyResponseContract::class => Responses\DeleteSystemSettingKeyResponse::class,
        Contracts\ImportSystemSettingResponseContract::class => Responses\ImportSystemSettingResponse::class,
        Contracts\UpdateSystemSettingGroupResponseContract::class => Responses\UpdateSystemSettingGroupResponse::class,

        Contracts\ListCategoryGroupResponseContract::class => Responses\ListCategoryGroupResponse::class,
        Contracts\ListCategoryResponseContract::class => Responses\ListCategoryResponse::class,
        Contracts\StoreCategoryGroupResponseContract::class => Responses\StoreCategoryGroupResponse::class,
        Contracts\UpdateCategoryGroupResponseContract::class => Responses\UpdateCategoryGroupResponse::class,
        Contracts\StoreCategoryResponseContract::class => Responses\StoreCategoryResponse::class,
        Contracts\UpdateCategoryResponseContract::class => Responses\UpdateCategoryResponse::class,

        Contracts\ListProductResponseContract::class => Responses\ListProductResponse::class,
        Contracts\StoreProductResponseContract::class => Responses\StoreProductResponse::class,
        Contracts\UpdateProductResponseContract::class => Responses\UpdateProductResponse::class,

        Contracts\ListAttributeResponseContract::class => Responses\ListAttributeResponse::class,
        Contracts\StoreAttributeResponseContract::class => Responses\StoreAttributeResponse::class,
        Contracts\UpdateAttributeResponseContract::class => Responses\UpdateAttributeResponse::class,
        Contracts\ListAttributeValueResponseContract::class => Responses\ListAttributeValueResponse::class,
        Contracts\StoreAttributeValueResponseContract::class => Responses\StoreAttributeValueResponse::class,
        Contracts\UpdateAttributeValueResponseContract::class => Responses\UpdateAttributeValueResponse::class,
        Contracts\DeleteAttributeValueResponseContract::class => Responses\DeleteAttributeValueResponse::class,

        Contracts\ListInventoryResponseContract::class => Responses\ListInventoryResponse::class,
        Contracts\StoreInventoryResponseContract::class => Responses\StoreInventoryResponse::class,
        Contracts\UpdateInventoryResponseContract::class => Responses\UpdateInventoryResponse::class,
        Contracts\DeleteInventoryResponseContract::class => Responses\DeleteInventoryResponse::class,

        Contracts\ListDisplayInventoryResponseContract::class => Responses\ListDisplayInventoryResponse::class,
        Contracts\StoreDisplayInventoryResponseContract::class => Responses\StoreDisplayInventoryResponse::class,
        Contracts\UpdateDisplayInventoryResponseContract::class => Responses\UpdateDisplayInventoryResponse::class,
        Contracts\DeleteDisplayInventoryResponseContract::class => Responses\DeleteDisplayInventoryResponse::class,

        Contracts\ListBannerResponseContract::class => Responses\ListBannerResponse::class,
        Contracts\StoreBannerResponseContract::class => Responses\StoreBannerResponse::class,
        Contracts\UpdateBannerResponseContract::class => Responses\UpdateBannerResponse::class,
        Contracts\DeleteBannerResponseContract::class => Responses\DeleteBannerResponse::class,

        Contracts\ListMenuGroupResponseContract::class => Responses\ListMenuGroupResponse::class,
        Contracts\StoreMenuGroupResponseContract::class => Responses\StoreMenuGroupResponse::class,
        Contracts\UpdateMenuGroupResponseContract::class => Responses\UpdateMenuGroupResponse::class,
        Contracts\DeleteMenuGroupResponseContract::class => Responses\DeleteMenuGroupResponse::class,

        Contracts\ListMenuSubGroupResponseContract::class => Responses\ListMenuSubGroupResponse::class,
        Contracts\StoreMenuSubGroupResponseContract::class => Responses\StoreMenuSubGroupResponse::class,
        Contracts\UpdateMenuSubGroupResponseContract::class => Responses\UpdateMenuSubGroupResponse::class,
        Contracts\DeleteMenuSubGroupResponseContract::class => Responses\DeleteMenuSubGroupResponse::class,

        Contracts\ListMenuResponseContract::class => Responses\ListMenuResponse::class,
        Contracts\StoreMenuResponseContract::class => Responses\StoreMenuResponse::class,
        Contracts\UpdateMenuResponseContract::class => Responses\UpdateMenuResponse::class,
        Contracts\DeleteMenuResponseContract::class => Responses\DeleteMenuResponse::class,

        Contracts\ListPostCategoryResponseContract::class => Responses\ListPostCategoryResponse::class,
        Contracts\StorePostCategoryResponseContract::class => Responses\StorePostCategoryResponse::class,
        Contracts\UpdatePostCategoryResponseContract::class => Responses\UpdatePostCategoryResponse::class,
        Contracts\DeletePostCategoryResponseContract::class => Responses\DeletePostCategoryResponse::class,

        Contracts\ListPostResponseContract::class => Responses\ListPostResponse::class,
        Contracts\StorePostResponseContract::class => Responses\StorePostResponse::class,
        Contracts\UpdatePostResponseContract::class => Responses\UpdatePostResponse::class,
        Contracts\DeletePostResponseContract::class => Responses\DeletePostResponse::class,

        Contracts\ListCollectionResponseContract::class => Responses\ListCollectionResponse::class,
        Contracts\StoreCollectionResponseContract::class => Responses\StoreCollectionResponse::class,
        Contracts\UpdateCollectionResponseContract::class => Responses\UpdateCollectionResponse::class,
        Contracts\DeleteCollectionResponseContract::class => Responses\DeleteCollectionResponse::class,

        Contracts\ListPageResponseContract::class => Responses\ListPageResponse::class,
        Contracts\StorePageResponseContract::class => Responses\StorePageResponse::class,
        Contracts\UpdatePageResponseContract::class => Responses\UpdatePageResponse::class,
        Contracts\DeletePageResponseContract::class => Responses\DeletePageResponse::class,

        Contracts\ListFaqTopicResponseContract::class => Responses\ListFaqTopicResponse::class,
        Contracts\StoreFaqTopicResponseContract::class => Responses\StoreFaqTopicResponse::class,
        Contracts\UpdateFaqTopicResponseContract::class => Responses\UpdateFaqTopicResponse::class,
        Contracts\DeleteFaqTopicResponseContract::class => Responses\DeleteFaqTopicResponse::class,

        Contracts\ListFaqResponseContract::class => Responses\ListFaqResponse::class,
        Contracts\StoreFaqResponseContract::class => Responses\StoreFaqResponse::class,
        Contracts\UpdateFaqResponseContract::class => Responses\UpdateFaqResponse::class,
        Contracts\DeleteFaqResponseContract::class => Responses\DeleteFaqResponse::class,

        Contracts\ListProductReviewResponseContract::class => Responses\ListProductReviewResponse::class,
        Contracts\StoreProductReviewResponseContract::class => Responses\StoreProductReviewResponse::class,
        Contracts\UpdateProductReviewResponseContract::class => Responses\UpdateProductReviewResponse::class,
        Contracts\DeleteProductReviewResponseContract::class => Responses\DeleteProductReviewResponse::class,

        Contracts\ListIncludedProductResponseContract::class => Responses\ListIncludedProductResponse::class,
        Contracts\StoreIncludedProductResponseContract::class => Responses\StoreIncludedProductResponse::class,
        Contracts\UpdateIncludedProductResponseContract::class => Responses\UpdateIncludedProductResponse::class,
        Contracts\DeleteIncludedProductResponseContract::class => Responses\DeleteIncludedProductResponse::class,

        Contracts\UploadFileManagerResponseContract::class => Responses\UploadFileManagerResponse::class,

        Contracts\ListSubscriberResponseContract::class => Responses\ListSubscriberResponse::class,
    ];
}
