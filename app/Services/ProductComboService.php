<?php

namespace App\Services;

use App\Repositories\Contracts\ProductComboRepositoryContract;
use App\Services\BaseService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductComboService extends BaseService
{
    public $includedProductRepository;

    public function __construct(ProductComboRepositoryContract $includedProductRepository)
    {
        $this->includedProductRepository = $includedProductRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->includedProductRepository
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->includedProductRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $attributes['image'] = $this->convertImage(data_get($attributes, 'image'));

            return $this->includedProductRepository->create($attributes);
        });
    }

    protected function convertImage($image)
    {
        if ($imageUrl = data_get($image, 'path')) {
            return $imageUrl;
        } else if (data_get($image, 'file') && data_get($image, 'file') instanceof UploadedFile) {
            $imageFile = data_get($image, 'file');
            $filename  = $this->catalogDisk()->putFile('/', $imageFile);
            $imageUrl = $this->catalogDisk()->url($filename);

            return $imageUrl;
        }

        return null;
    }

    public function show($id, $columns = ['*'])
    {
        return $this->includedProductRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $attributes['image'] = $this->convertImage(data_get($attributes, 'image'));

            return $this->includedProductRepository->update($attributes, $id);
        });
    }

    public function delete($id)
    {
        return $this->includedProductRepository->delete($id);
    }

    protected function catalogDisk()
    {
        return Storage::disk('catalog');
    }
}
