<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryContract;
use App\Services\BaseService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryService extends BaseService
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

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            if (! empty($attributes['icon_image']) && $attributes['icon_image'] instanceof UploadedFile) {
                $iconImageFile = $this->bankSlipDisk()->putFile('/', $attributes['icon_image']);
                $attributes['icon_image'] = $this->bankSlipDisk()->url($iconImageFile);
            }

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
            if (! empty($attributes['icon_image']) && $attributes['icon_image'] instanceof UploadedFile) {
                $iconImageFile = $this->bankSlipDisk()->putFile('/', $attributes['icon_image']);
                $attributes['icon_image'] = $this->bankSlipDisk()->url($iconImageFile);
            }

            return $this->categoryRepository->update($attributes, $id);
        });
    }

    protected function bankSlipDisk()
    {
        return Storage::disk('catalog');
    }
}
