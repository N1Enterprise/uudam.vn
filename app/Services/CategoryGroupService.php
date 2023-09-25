<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryGroupRepositoryContract;
use App\Services\BaseService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryGroupService extends BaseService
{
    public $categoryGroupRepository;

    public function __construct(CategoryGroupRepositoryContract $categoryGroupRepository)
    {
        $this->categoryGroupRepository = $categoryGroupRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->categoryGroupRepository
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->categoryGroupRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $attributes['primary_image'] = $this->convertImage(data_get($attributes, 'primary_image'));

            return $this->categoryGroupRepository->create($attributes);
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
        return $this->categoryGroupRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $attributes['primary_image'] = $this->convertImage(data_get($attributes, 'primary_image'));

            return $this->categoryGroupRepository->update($attributes, $id);
        });
    }

    protected function catalogDisk()
    {
        return Storage::disk('catalog');
    }
}
