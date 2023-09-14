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

    public function allAvailable($columns = ['*'])
    {
        return $this->categoryGroupRepository->modelScopes(['active'])
            ->all($columns);
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            if (! empty($attributes['icon_image']) && $attributes['icon_image'] instanceof UploadedFile) {
                $iconImageFile = $this->bankSlipDisk()->putFile('/', $attributes['icon_image']);
                $attributes['icon_image'] = $this->bankSlipDisk()->url($iconImageFile);
            }

            return $this->categoryGroupRepository->create($attributes);
        });
    }

    public function show($id, $columns = ['*'])
    {
        return $this->categoryGroupRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            if (! empty($attributes['icon_image']) && $attributes['icon_image'] instanceof UploadedFile) {
                $iconImageFile = $this->bankSlipDisk()->putFile('/', $attributes['icon_image']);
                $attributes['icon_image'] = $this->bankSlipDisk()->url($iconImageFile);
            }

            return $this->categoryGroupRepository->update($attributes, $id);
        });
    }

    protected function bankSlipDisk()
    {
        return Storage::disk('catalog');
    }
}
