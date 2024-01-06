<?php

namespace App\Services;

use App\Common\ImageHelper;
use App\Models\Collection;
use App\Repositories\Contracts\CollectionRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CollectionService extends BaseService
{
    public $collectionRepository;
    public $inventoryService;

    public function __construct(CollectionRepositoryContract $collectionRepository, InventoryService $inventoryService)
    {
        $this->collectionRepository = $collectionRepository;
        $this->inventoryService = $inventoryService;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->collectionRepository
            ->whereColumnsLike($data['query'] ?? null, ['name', 'slug', 'cta_label'])
            ->search([]);

        return $result;
    }

    public function searchForGuest($data = [])
    {
        $where = [];

        $result = $this->collectionRepository
            ->with(data_get($data, 'with', []))
            ->modelScopes(['active', 'feDisplay'])
            ->scopeQuery(function($q) use ($data) {
                $q->whereIn('id', Arr::wrap(data_get($data, 'filter_ids', [])));
            })
            ->orderBy('order');

        return $result->search($where, null, ['*'], true, data_get($data, 'paging', 'paginate'));
    }

    public function allAvailable($data = [])
    {
        return $this->collectionRepository
            ->modelScopes(array_merge(['active'], data_get($data, 'scopes', [])))
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function showBySlug($slug, $data = [])
    {
        return $this->collectionRepository
            ->modelScopes(['active'])
            ->firstWhere(['slug' => $slug], data_get($data, 'columns', ['*']));
    }

    public function getLinkedInventories($id, $data = [])
    {
        $collection = $this->show($id);

        $linkedInventories = data_get($collection, 'linked_inventories', []);

        $inventories = $this->inventoryService->searchForGuest(array_merge(['filter_ids' => $linkedInventories], $data));

        return $inventories;
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $imageHelper = ImageHelper::make('appearance')->hasOptimization();

            $attributes['primary_image'] = $imageHelper
                ->setConfigKey([Collection::class, 'primary_image'])
                ->uploadImage(data_get($attributes, 'primary_image'));

            $attributes['cover_image'] = $imageHelper
                ->setConfigKey([Collection::class, 'cover_image'])
                ->uploadImage(data_get($attributes, 'cover_image'));

            $collection = $this->collectionRepository->create($attributes);

            return $collection;
        });
    }

    public function show($id, $data = [])
    {
        return $this->collectionRepository
            ->with(data_get($data, 'with', []))
            ->findOrFail($id, data_get($data, 'columns', ['*']));
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function() use ($attributes, $id) {
            $collection = $this->show($id);

            $imageHelper = ImageHelper::make('appearance')->hasOptimization();

            $attributes['primary_image'] = $imageHelper
                ->setConfigKey([Collection::class, 'primary_image'])
                ->uploadImage(data_get($attributes, 'primary_image'));

            $attributes['cover_image'] = $imageHelper
                ->setConfigKey([Collection::class, 'cover_image'])
                ->uploadImage(data_get($attributes, 'cover_image'));

            $collection = $this->collectionRepository->update($attributes, $collection->getKey());

            return $collection;
        });
    }

    public function delete($id)
    {
        return $this->collectionRepository->delete($id);
    }
}
