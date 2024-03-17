<?php

namespace App\Http\Controllers\Frontend;

use App\Cms\BannerCms;
use App\Cms\HomePageDisplayOrderCms;
use App\Enum\SystemSettingKeyEnum;
use App\Models\SystemSetting;
use App\Services\BannerService;
use App\Services\HomePageDisplayOrderService;
use App\Services\VideoCategoryService;

class HomeController extends BaseController
{
    public $bannerService;
    public $homePageDisplayOrderService;
    public $videoCategoryService;

    public function __construct(
        BannerService $bannerService,
        HomePageDisplayOrderService $homePageDisplayOrderService,
        VideoCategoryService $videoCategoryService
    ) {
        $this->bannerService = $bannerService;
        $this->homePageDisplayOrderService = $homePageDisplayOrderService;
        $this->videoCategoryService = $videoCategoryService;
    }

    public function index()
    {
        $homeBanners = BannerCms::make()->homeBanners();
        $videoOutsideUI = SystemSetting::from(SystemSettingKeyEnum::VIDEO_OUTSIDE_UI)->get(null, []);
        $homePageDisplayOrders = HomePageDisplayOrderCms::make()->available();
        $videoCategories = $this->videoCategoryService->searchByGuest(['paginate' => false]);

        return $this->view('frontend.pages.home.index', compact(
            'homeBanners',
            'homePageDisplayOrders',
            'videoOutsideUI',
            'videoCategories'
        ));
    }
}
