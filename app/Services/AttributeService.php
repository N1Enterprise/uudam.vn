<?php

namespace App\Services;

use App\Models\Attribute;
use App\Repositories\Contracts\AttributeRepositoryContract;
use Illuminate\Support\Facades\DB;

class AttributeService extends BaseService
{
    public $attributeRepository;

    public function __construct(AttributeRepositoryContract $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->attributeRepository
            ->with(['categories'])
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->attributeRepository
            ->modelScopes(['active'])
            ->all(data_get($data, 'columns', ['*']));
    }

    public function show($id, $data = [])
    {
        return $this->attributeRepository
            ->with(data_get($data, 'with', []))
            ->findOrFail($id, data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $attribute = $this->attributeRepository->create($attributes);

            $this->syncCategories($attribute, data_get($attributes, 'categories', []));

            return $attribute;
        });
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $attribute = $this->attributeRepository->update($attributes, $id);

            $this->syncCategories($attribute, data_get($attributes, 'categories', []));

            return $attribute;
        });
    }

    protected function syncCategories(Attribute $attribute, $categories = [])
    {
        return $attribute->categories()->sync($categories);
    }
}
