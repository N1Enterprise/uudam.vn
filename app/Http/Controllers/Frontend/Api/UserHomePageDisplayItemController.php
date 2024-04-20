<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Contracts\Responses\Frontend\ListLinkedBannerResponseContract;
use App\Contracts\Responses\Frontend\ListLinkedBlogResponseContract;
use App\Contracts\Responses\Frontend\ListLinkedCollectionResponseContract;
use App\Contracts\Responses\Frontend\ListLinkedInventoryResponseContract;
use App\Contracts\Responses\Frontend\ListLinkedPostResponseContract;
use App\Enum\BannerTypeEnum;
use App\Services\BannerService;
use App\Services\CollectionService;
use App\Services\HomePageDisplayItemService;
use App\Services\InventoryService;
use App\Services\PostCategoryService;
use App\Services\PostService;
use Illuminate\Support\Arr;

class UserHomePageDisplayItemController extends BaseApiController
{
    public $homePageDisplayItemService;
    public $inventoryService;
    public $collectionService;
    public $postService;
    public $postCategoryService;
    public $bannerService;

    public function __construct(
        HomePageDisplayItemService $homePageDisplayItemService,
        InventoryService $inventoryService,
        CollectionService $collectionService,
        PostService $postService,
        PostCategoryService $postCategoryService,
        BannerService $bannerService
    ) {
        parent::__construct();

        $this->homePageDisplayItemService = $homePageDisplayItemService;
        $this->inventoryService = $inventoryService;
        $this->collectionService = $collectionService;
        $this->postService = $postService;
        $this->postCategoryService = $postCategoryService;
        $this->bannerService = $bannerService;
    }

    public function getInventories($id)
    {
        $displayItem = $this->homePageDisplayItemService->show($id);

        $inventoryIds = Arr::wrap(data_get($displayItem, 'linked_items', []));

        $inventories = $this->inventoryService->searchForGuest(['filter_ids' => $inventoryIds, 'with' => 'product']);

        return $this->response(ListLinkedInventoryResponseContract::class, $inventories);
    }

    public function getCollections($id)
    {
        $displayItem = $this->homePageDisplayItemService->show($id);

        $collectionIds = Arr::wrap(data_get($displayItem, 'linked_items', []));

        $collections = $this->collectionService->searchForGuest(['filter_ids' => $collectionIds]);

        return $this->response(ListLinkedCollectionResponseContract::class, $collections);
    }

    public function getPosts($id)
    {
        $displayItem = $this->homePageDisplayItemService->show($id);

        $postIds = Arr::wrap(data_get($displayItem, 'linked_items', []));

        $posts = $this->postService->searchForGuest(['filter_ids' => $postIds]);

        return $this->response(ListLinkedPostResponseContract::class, $posts);
    }

    public function getBlogs($id)
    {
        $displayItem = $this->homePageDisplayItemService->show($id);

        $blogIds = Arr::wrap(data_get($displayItem, 'linked_items', []));

        $blogs = $this->postCategoryService->searchForGuest(['filter_ids' => $blogIds]);

        return $this->response(ListLinkedBlogResponseContract::class, $blogs);
    }

    public function getBanners100($id)
    {
        $displayItem = $this->homePageDisplayItemService->show($id);

        $bannerIds = Arr::wrap(data_get($displayItem, 'linked_items', []));

        $blogs = $this->bannerService->searchForGuest(['filter_ids' => $bannerIds, 'type' => BannerTypeEnum::IN_APP_100_PERCENT]);

        return $this->response(ListLinkedBannerResponseContract::class, $blogs);
    }

    public function getBanners50($id)
    {
        $displayItem = $this->homePageDisplayItemService->show($id);

        $bannerIds = Arr::wrap(data_get($displayItem, 'linked_items', []));

        $blogs = $this->bannerService->searchForGuest(['filter_ids' => $bannerIds, 'type' => BannerTypeEnum::IN_APP_50_PERCENT]);

        return $this->response(ListLinkedBannerResponseContract::class, $blogs);
    }
}
