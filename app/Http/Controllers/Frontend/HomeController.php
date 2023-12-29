<?php

namespace App\Http\Controllers\Frontend;

use App\Cms\BannerCms;
use App\Cms\HomePageDisplayOrderCms;
use App\Enum\SystemSettingKeyEnum;
use App\Models\SystemSetting;
use App\Services\BannerService;
use App\Services\HomePageDisplayOrderService;

class HomeController extends BaseController
{
    public $bannerService;
    public $homePageDisplayOrderService;

    public function __construct(
        BannerService $bannerService,
        HomePageDisplayOrderService $homePageDisplayOrderService
    ) {
        $this->bannerService = $bannerService;
        $this->homePageDisplayOrderService = $homePageDisplayOrderService;
    }

    public function index()
    {
        $homeBanners = BannerCms::make()->homeBanners();
        $videoOutsideUI = SystemSetting::from(SystemSettingKeyEnum::VIDEO_OUTSIDE_UI)->get(null, []);
        $homePageDisplayOrders = HomePageDisplayOrderCms::make()->available();

        return $this->view('frontend.pages.home.index', compact(
            'homeBanners',
            'homePageDisplayOrders',
            'videoOutsideUI'
        ));
    }
}
