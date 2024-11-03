<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreHomePageDisplayItemRequestContract;
use App\Contracts\Requests\Backoffice\UpdateHomePageDisplayItemRequestContract;
use App\Contracts\Responses\Backoffice\DeleteHomePageDisplayItemResponseContract;
use App\Contracts\Responses\Backoffice\StoreHomePageDisplayItemResponseContract;
use App\Contracts\Responses\Backoffice\UpdateHomePageDisplayItemResponseContract;
use App\Enum\BannerTypeEnum;
use App\Enum\HomePageDisplayType;
use App\Services\BannerService;
use App\Services\CollectionService;
use App\Services\HomePageDisplayItemService;
use App\Services\HomePageDisplayOrderService;
use App\Services\InventoryService;
use App\Services\PostCategoryService;
use App\Services\PostService;
use Illuminate\Http\Request;

class HomePageDisplayItemController extends BaseController
{
    public $homePageDisplayItemService;
    public $inventoryService;
    public $collectionService;
    public $homePageDisplayOrderService;
    public $postService;
    public $postCategoryService;
    public $bannerService;

    public function __construct(
        HomePageDisplayItemService $homePageDisplayItemService,
        InventoryService $inventoryService,
        CollectionService $collectionService,
        HomePageDisplayOrderService $homePageDisplayOrderService,
        PostService $postService,
        PostCategoryService $postCategoryService,
        BannerService $bannerService
    ) {
        $this->homePageDisplayItemService = $homePageDisplayItemService;
        $this->inventoryService = $inventoryService;
        $this->collectionService = $collectionService;
        $this->homePageDisplayOrderService = $homePageDisplayOrderService;
        $this->postService = $postService;
        $this->postCategoryService = $postCategoryService;
        $this->bannerService = $bannerService;
    }

    public function index()
    {
        return view('backoffice.pages.home-page-display-items.index');
    }

    public function create(Request $request)
    {
        $homePageDisplayTypeEnumLabels = HomePageDisplayType::labels();
        $inventories = $this->inventoryService->allAvailableForGuest();
        $collections = $this->collectionService->allAvailable(['scopes' => ['feDisplay']]);
        $posts = $this->postService->allAvailable(['scopes' => ['feDisplay']]);
        $postCategories = $this->postCategoryService->allAvailable(['scopes' => ['feDisplay']]);
        $groups = $this->homePageDisplayOrderService->allAvailable();
        $banners = $this->bannerService->allAvailable([
            'condition' => [
                'types' => [BannerTypeEnum::IN_APP_100_PERCENT, BannerTypeEnum::IN_APP_50_PERCENT]
            ]
        ]);

        $banners100Percent = $banners->filter(fn($item) => data_get($item, 'type') == BannerTypeEnum::IN_APP_100_PERCENT);
        $banners50Percent = $banners->filter(fn($item) => data_get($item, 'type') == BannerTypeEnum::IN_APP_50_PERCENT);

        return view('backoffice.pages.home-page-display-items.create', compact(
            'homePageDisplayTypeEnumLabels',
            'inventories',
            'collections',
            'groups',
            'posts',
            'postCategories',
            'banners100Percent',
            'banners50Percent',
        ));
    }

    public function edit($id)
    {
        $homePageDisplayItem = $this->homePageDisplayItemService->show($id);
        $homePageDisplayTypeEnumLabels = HomePageDisplayType::labels();
        $inventories = $this->inventoryService->allAvailableForGuest();
        $collections = $this->collectionService->allAvailable(['scopes' => ['feDisplay']]);
        $posts = $this->postService->allAvailable(['scopes' => ['feDisplay']]);
        $postCategories = $this->postCategoryService->allAvailable(['scopes' => ['feDisplay']]);
        $groups = $this->homePageDisplayOrderService->allAvailable();
        $banners = $this->bannerService->allAvailable([
            'condition' => [
                'types' => [BannerTypeEnum::IN_APP_100_PERCENT, BannerTypeEnum::IN_APP_50_PERCENT]
            ]
        ]);

        $banners100Percent = $banners->filter(fn($item) => data_get($item, 'type') == BannerTypeEnum::IN_APP_100_PERCENT);
        $banners50Percent = $banners->filter(fn($item) => data_get($item, 'type') == BannerTypeEnum::IN_APP_50_PERCENT);

        return view('backoffice.pages.home-page-display-items.edit', compact(
            'homePageDisplayItem',
            'homePageDisplayTypeEnumLabels',
            'inventories',
            'collections',
            'groups',
            'posts',
            'postCategories',
            'banners100Percent',
            'banners50Percent',
        ));
    }

    public function store(StoreHomePageDisplayItemRequestContract $request)
    {
        $homePageDisplayItem = $this->homePageDisplayItemService->create($request->validated());

        return $this->response(StoreHomePageDisplayItemResponseContract::class, $homePageDisplayItem);
    }

    public function update(UpdateHomePageDisplayItemRequestContract $request, $id)
    {
        $homePageDisplayItem = $this->homePageDisplayItemService->update($request->validated(), $id);

        return $this->response(UpdateHomePageDisplayItemResponseContract::class, $homePageDisplayItem);
    }

    public function destroy($id)
    {
        $status = $this->homePageDisplayItemService->delete($id);

        return $this->response(DeleteHomePageDisplayItemResponseContract::class, ['status' => $status]);
    }
}
