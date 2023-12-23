<?php

namespace App\Http\Controllers\Frontend;

use App\Enum\BannerTypeEnum;
use App\Enum\SystemSettingKeyEnum;
use App\Models\SystemSetting;
use App\Services\HomePageDisplayOrderService;
use App\Services\PostCategoryService;
use App\Services\StoreFront\StoreFrontBannerService;

class HomeController extends BaseController
{
    public $storeFrontBannerService;
    public $postCategoryService;
    public $homePageDisplayOrderService;

    public function __construct(
        StoreFrontBannerService $storeFrontBannerService,
        PostCategoryService $postCategoryService,
        HomePageDisplayOrderService $homePageDisplayOrderService
    ) {
        $this->storeFrontBannerService = $storeFrontBannerService;
        $this->postCategoryService = $postCategoryService;
        $this->homePageDisplayOrderService = $homePageDisplayOrderService;
    }

    public function index()
    {
        $homeBanners = $this->storeFrontBannerService->allAvailableBannerByType(BannerTypeEnum::HOME_BANNER);
        $postCategories = $this->postCategoryService->getAvailableDisplayOnFE(['with' => 'posts']);
        $videoOutsideUI = SystemSetting::from(SystemSettingKeyEnum::VIDEO_OUTSIDE_UI)->get(null, []);
        $homePageDisplayOrders = $this->homePageDisplayOrderService->searchAvailableByGuest([]);

        return $this->view('frontend.pages.home.index', compact(
            'homeBanners',
            'homePageDisplayOrders',
            'postCategories',
            'videoOutsideUI'
        ));
    }
}
