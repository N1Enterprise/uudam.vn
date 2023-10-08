<?php

namespace App\Http\Controllers\Frontend;

use App\Enum\BannerTypeEnum;
use App\Enum\DisplayInventoryTypeEnum;
use App\Services\StoreFrontBannerService;
use App\Services\StoreFrontProductDisplayService;

class HomeController extends BaseController
{
    public $storeFrontBannerService;
    public $storeFrontProductDisplayService;

    public function __construct(
        StoreFrontBannerService $storeFrontBannerService,
        StoreFrontProductDisplayService $storeFrontProductDisplayService
    ) {
        $this->storeFrontBannerService = $storeFrontBannerService;
        $this->storeFrontProductDisplayService = $storeFrontProductDisplayService;
    }

    public function index()
    {
        $homeBanners = $this->storeFrontBannerService->allAvailableBannerByType(BannerTypeEnum::HOME_BANNER);
        $popularInventories = $this->storeFrontProductDisplayService->allAvailableInventoryDisplayedByType(DisplayInventoryTypeEnum::POPULAR);
        $youMayLikeInventories = $this->storeFrontProductDisplayService->allAvailableInventoryDisplayedByType(DisplayInventoryTypeEnum::YOU_MAY_LIKE);

        return $this->view('frontend.pages.home.index', compact('homeBanners', 'popularInventories', 'youMayLikeInventories'));
    }
}
