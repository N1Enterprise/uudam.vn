<?php

namespace App\Services;

use App\Common\ImageHelper;
use App\Enum\ActivationStatusEnum;
use App\Repositories\Contracts\CategoryRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

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

    public function allAvailable($data = [])
    {
        if (data_get($data, 'with.products')) {
            $data['with']['products'] = ['products' => function($q) {
                $q->where('status', ActivationStatusEnum::ACTIVE);
            }];
        }

        return $this->categoryRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $attributes['primary_image'] = ImageHelper::make('catalog')
                ->uploadImage(data_get($attributes, 'primary_image'));

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
            $attributes['primary_image'] = ImageHelper::make('catalog')
                ->uploadImage(data_get($attributes, 'primary_image'));

            return $this->categoryRepository->update($attributes, $id);
        });
    }
}
