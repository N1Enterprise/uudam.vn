<?php

namespace App\Http\Controllers\Frontend;

use App\Enum\BannerTypeEnum;
use App\Enum\SystemSettingKeyEnum;
use App\Models\SystemSetting;
use App\Services\HomePageDisplayOrderService;
use App\Services\StoreFront\StoreFrontBannerService;

class HomeController extends BaseController
{
    public $storeFrontBannerService;
    public $homePageDisplayOrderService;

    public function __construct(
        StoreFrontBannerService $storeFrontBannerService,
        HomePageDisplayOrderService $homePageDisplayOrderService
    ) {
        $this->storeFrontBannerService = $storeFrontBannerService;
        $this->homePageDisplayOrderService = $homePageDisplayOrderService;
    }

    public function index()
    {
        $homeBanners = $this->storeFrontBannerService->allAvailableBannerByType(BannerTypeEnum::HOME_BANNER, ['columns' => ['id', 'desktop_image', 'mobile_image', 'label', 'description', 'redirect_url']]);
        $videoOutsideUI = SystemSetting::from(SystemSettingKeyEnum::VIDEO_OUTSIDE_UI)->get(null, []);
        $homePageDisplayOrders = $this->homePageDisplayOrderService->searchAvailableByGuest([]);

        return $this->view('frontend.pages.home.index', compact(
            'homeBanners',
            'homePageDisplayOrders',
            'videoOutsideUI'
        ));
    }
}
