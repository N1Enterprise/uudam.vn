<?php

namespace App\Services;

use App\Models\Collection;
use App\Repositories\Contracts\CollectionRepositoryContract;
use App\Services\BaseService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CollectionService extends BaseService
{
    public $collectionRepository;

    public function __construct(CollectionRepositoryContract $collectionRepository)
    {
        $this->collectionRepository = $collectionRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->collectionRepository
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->collectionRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $attributes['primary_image'] = $this->convertImage(data_get($attributes, 'primary_image'));
            $attributes['cover_image'] = $this->convertImage(data_get($attributes, 'cover_image'));

            $collection = $this->collectionRepository->create($attributes);

            $this->syncInventories($collection, data_get($attributes, 'inventories', []));

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

            $attributes['primary_image'] = $this->convertImage(data_get($attributes, 'primary_image'));
            $attributes['cover_image'] = $this->convertImage(data_get($attributes, 'cover_image'));

            $collection = $this->collectionRepository->update($attributes, $collection->getKey());

            $this->syncInventories($collection, data_get($attributes, 'inventories', []));

            return $collection;
        });
    }

    public function delete($id)
    {
        return $this->collectionRepository->delete($id);
    }

    protected function syncInventories(Collection $collection, $inventories = [])
    {
        return $collection->inventories()->sync($inventories);
    }

    protected function convertImage($image)
    {
        if ($imageUrl = data_get($image, 'path')) {
            return $imageUrl;
        } else if (data_get($image, 'file') && data_get($image, 'file') instanceof UploadedFile) {
            $imageFile = data_get($image, 'file');
            $filename  = $this->appearanceDisk()->putFile('/', $imageFile);
            $imageUrl = $this->appearanceDisk()->url($filename);

            return $imageUrl;
        }

        return null;
    }

    protected function appearanceDisk()
    {
        return Storage::disk('appearance');
    }
}
