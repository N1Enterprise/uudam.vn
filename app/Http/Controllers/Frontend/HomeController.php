<?php

namespace App\Http\Controllers\Frontend;

use App\Enum\BannerTypeEnum;
use App\Enum\DisplayInventoryTypeEnum;
use App\Enum\SystemSettingKeyEnum;
use App\Models\SystemSetting;
use App\Services\CollectionService;
use App\Services\PostCategoryService;
use App\Services\StoreFront\StoreFrontBannerService;
use App\Services\StoreFront\StoreFrontProductDisplayService;

class HomeController extends BaseController
{
    public $storeFrontBannerService;
    public $storeFrontProductDisplayService;
    public $collectionService;
    public $postCategoryService;

    public function __construct(
        StoreFrontBannerService $storeFrontBannerService,
        StoreFrontProductDisplayService $storeFrontProductDisplayService,
        CollectionService $collectionService,
        PostCategoryService $postCategoryService
    ) {
        $this->storeFrontBannerService = $storeFrontBannerService;
        $this->storeFrontProductDisplayService = $storeFrontProductDisplayService;
        $this->collectionService = $collectionService;
        $this->postCategoryService = $postCategoryService;
    }

    public function index()
    {
        $homeBanners = $this->storeFrontBannerService->allAvailableBannerByType(BannerTypeEnum::HOME_BANNER);
        $popularInventories = $this->storeFrontProductDisplayService->allAvailableInventoryDisplayedByType(DisplayInventoryTypeEnum::POPULAR);
        $youMayLikeInventories = $this->storeFrontProductDisplayService->allAvailableInventoryDisplayedByType(DisplayInventoryTypeEnum::YOU_MAY_LIKE);
        $collections = $this->collectionService
            ->allAvailable(['columns' => ['id', 'slug', 'name', 'primary_image', 'cta_label', 'featured', 'display_on_frontend']])
            ->sortBy('order');

        $displayOnFrontendCollections = $collections->where('display_on_frontend', 1);
        $featuredCollections = $collections->where('featured', 1);

        $postCategories = $this->postCategoryService->getAvailableDisplayOnFE(['with' => 'posts']);
        $videoOutsideUI = SystemSetting::from(SystemSettingKeyEnum::VIDEO_OUTSIDE_UI)->get(null, []);

        return $this->view('frontend.pages.home.index', compact(
            'homeBanners',
            'popularInventories',
            'youMayLikeInventories',
            'displayOnFrontendCollections',
            'featuredCollections',
            'postCategories',
            'videoOutsideUI'
        ));
    }
}
