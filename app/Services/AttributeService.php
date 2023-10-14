<?php

namespace App\Services;

use App\Models\Attribute;
use App\Repositories\Contracts\AttributeRepositoryContract;
use Illuminate\Support\Facades\DB;

class AttributeService extends BaseService
{
    public $attributeRepository;
    public $attributeValueService;

    public function __construct(AttributeRepositoryContract $attributeRepository, AttributeValueService $attributeValueService)
    {
        $this->attributeRepository = $attributeRepository;
        $this->attributeValueService = $attributeValueService;
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

    public function confirmAttributes($attributeValues = [])
    {
        $results = array();

        foreach ($attributeValues as $attributeId => $valueIds){
            foreach ($valueIds as $valueId){
                $oldValue = $this->attributeValueService->show($valueId);

                if ($oldValue){
                    $results[$attributeId][$oldValue->id] = $oldValue->value;
                }
            }
        }

        return $results;
    }

    protected function syncCategories(Attribute $attribute, $categories = [])
    {
        return $attribute->categories()->sync($categories);
    }

    public function getAttributesByInventories($inventoryIds = [])
    {
        $attrInventorySubQuery = DB::table('attribute_inventories')
            ->whereIn('inventory_id', $inventoryIds);

        $attributes = $this->attributeRepository
            ->with(['attributeValues' => function($q) use ($attrInventorySubQuery) {
                $q->whereIn('id', $attrInventorySubQuery->select('attribute_value_id'))
                    ->orderBy('order');
            }])
            ->scopeQuery(function($q) use ($attrInventorySubQuery) {
                $q->whereIn('id', $attrInventorySubQuery->select('attribute_id'));
            })
            ->orderBy('order')
            ->all(['id', 'name', 'attribute_type', 'order']);

        return $attributes;
    }
}
