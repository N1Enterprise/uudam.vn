<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListCollectionResponseContract;
use App\Services\CollectionService;
use Illuminate\Http\Request;

class CollectionController extends BaseApiController
{
    public $collectionService;

    public function __construct(CollectionService $collectionService)
    {
        $this->collectionService = $collectionService;
    }

    public function index(Request $request)
    {
        $collections = $this->collectionService->searchByAdmin($request->all());

        return $this->response(ListCollectionResponseContract::class, $collections);
    }
}
