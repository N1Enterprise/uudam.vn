<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryContract;
use App\Services\BaseService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MenuSubGroupService extends BaseService
{
    public $categoryRepository;

    public function __construct(CategoryRepositoryContract $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->categoryRepository
            ->with(['categoryGroup'])
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->categoryRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $attributes['primary_image'] = $this->convertImage(data_get($attributes, 'primary_image'));

            return $this->categoryRepository->create($attributes);
        });
    }

    public function show($id, $columns = ['*'])
    {
        return $this->categoryRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $attributes['primary_image'] = $this->convertImage(data_get($attributes, 'primary_image'));

            return $this->categoryRepository->update($attributes, $id);
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

    protected function catalogDisk()
    {
        return Storage::disk('catalog');
    }
}
