<?php

namespace App\Services;

use App\Common\ImageHelper;
use App\Repositories\Contracts\CategoryGroupRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

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
            $attributes['primary_image'] = ImageHelper::make('catalog')->uploadImage(data_get($attributes, 'primary_image'));

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
            $attributes['primary_image'] = ImageHelper::make('catalog')->uploadImage(data_get($attributes, 'primary_image'));

            return $this->categoryGroupRepository->update($attributes, $id);
        });
    }
}
