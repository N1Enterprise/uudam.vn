<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreCollectionRequestContract;
use App\Contracts\Requests\Backoffice\UpdateCollectionRequestContract;
use App\Contracts\Responses\Backoffice\DeleteCollectionResponseContract;
use App\Contracts\Responses\Backoffice\StoreCollectionResponseContract;
use App\Contracts\Responses\Backoffice\UpdateCollectionResponseContract;
use App\Services\CollectionService;
use App\Services\InventoryService;

class CollectionController extends BaseController
{
    public $collectionService;
    public $inventoryService;

    public function __construct(CollectionService $collectionService, InventoryService $inventoryService)
    {
        $this->collectionService = $collectionService;
        $this->inventoryService = $inventoryService;
    }

    public function index()
    {
        return view('backoffice.pages.collections.index');
    }

    public function create()
    {
        $inventories = $this->inventoryService->allAvailableForGuest();

        return view('backoffice.pages.collections.create', compact('inventories'));
    }

    public function edit($id)
    {
        $collection = $this->collectionService->show($id);
        $inventories = $this->inventoryService->allAvailableForGuest();

        return view('backoffice.pages.collections.edit', compact('collection', 'inventories'));
    }

    public function store(StoreCollectionRequestContract $request)
    {
        $collection = $this->collectionService->create($request->validated());

        return $this->response(StoreCollectionResponseContract::class, $collection);
    }

    public function update(UpdateCollectionRequestContract $request, $id)
    {
        $collection = $this->collectionService->update($request->validated(), $id);

        return $this->response(UpdateCollectionResponseContract::class, $collection);
    }

    public function destroy($id)
    {
        $status = $this->collectionService->delete($id);

        return $this->response(DeleteCollectionResponseContract::class, ['status' => $status]);
    }
}
