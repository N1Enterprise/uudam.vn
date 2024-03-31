<?php

namespace App\Services;

use App\Repositories\Contracts\AttributeValueRepositoryContract;
use Illuminate\Support\Facades\DB;

class AttributeValueService extends BaseService
{
    public $attributeValueRepository;

    public function __construct(AttributeValueRepositoryContract $attributeValueRepository)
    {
        $this->attributeValueRepository = $attributeValueRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->attributeValueRepository
            ->with(['attribute'])
            ->whereColumnsLike($data['query'] ?? null, ['value'])
            ->scopeQuery(function($q) use ($data) {
                $attributeId = data_get($data, 'attribute_id');

                if ($attributeId) {
                    $q->where('attribute_id', $attributeId);
                }
            })
            ->search([]);

        return $result;
    }

    public function show($id, $data = [])
    {
        return $this->attributeValueRepository
            ->with(data_get($data, 'with', []))
            ->findOrFail($id, data_get($data, 'columns', ['*']));
    }

    public function create($attributeValues = [])
    {
        return DB::transaction(function () use ($attributeValues) {
            $attributeValue = $this->attributeValueRepository->create($attributeValues);

            return $attributeValue;
        });
    }

    public function update($attributeValues = [], $id)
    {
        return DB::transaction(function () use ($attributeValues, $id) {
            $attributeValue = $this->attributeValueRepository->update($attributeValues, $id);

            return $attributeValue;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function() use ($id) {
            $status = $this->attributeValueRepository->delete($id);

            return $status;
        });
    }
}
