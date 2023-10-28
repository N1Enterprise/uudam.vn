<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Contracts\Requests\Frontend\StoreUserSubscribeRequestContract;
use App\Contracts\Responses\Frontend\ListLinkedInventoryResponseContract;
use App\Enum\CollectionTypeEnum;
use App\Services\CollectionService;
use Illuminate\Http\Request;

class CollectionController extends BaseApiController
{
    public $collectionService;

    public function __construct(CollectionService $collectionService)
    {
        $this->collectionService = $collectionService;
    }

    public function getLinkedInventories(Request $request, $id)
    {
        $linkedInventories = $this->collectionService->getLinkedInventories($id, $request->all());

        return $this->response(ListLinkedInventoryResponseContract::class, $linkedInventories);
    }
}
