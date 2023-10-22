<?php

namespace App\Http\Controllers\Frontend;

use App\Enum\BannerTypeEnum;
use App\Enum\DisplayInventoryTypeEnum;
use App\Services\PostService;
use App\Services\StoreFront\StoreFrontBannerService;
use App\Services\StoreFront\StoreFrontProductDisplayService;

class HomeController extends BaseController
{
    public $storeFrontBannerService;
    public $storeFrontProductDisplayService;
    public $postService;

    public function __construct(
        StoreFrontBannerService $storeFrontBannerService,
        StoreFrontProductDisplayService $storeFrontProductDisplayService,
        PostService $postService
    ) {
        $this->storeFrontBannerService = $storeFrontBannerService;
        $this->storeFrontProductDisplayService = $storeFrontProductDisplayService;
        $this->postService = $postService;
    }

    public function index()
    {
        $homeBanners = $this->storeFrontBannerService->allAvailableBannerByType(BannerTypeEnum::HOME_BANNER);
        $popularInventories = $this->storeFrontProductDisplayService->allAvailableInventoryDisplayedByType(DisplayInventoryTypeEnum::POPULAR);
        $youMayLikeInventories = $this->storeFrontProductDisplayService->allAvailableInventoryDisplayedByType(DisplayInventoryTypeEnum::YOU_MAY_LIKE);
        $featuredPosts = $this->postService->getListFeatured([
            'columns' => ['slug', 'name', 'image', 'description', 'post_at']
        ]);

        return $this->view('frontend.pages.home.index', compact('homeBanners', 'popularInventories', 'youMayLikeInventories', 'featuredPosts'));
    }
}
