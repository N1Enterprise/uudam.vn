<?php

namespace App\Services;

use App\Enum\ProductReviewStatusEnum;
use App\Repositories\Contracts\ProductReviewRepositoryContract;
use App\Services\BaseService;

class ProductReviewService extends BaseService
{
    public $productReviewRepository;

    public function __construct(ProductReviewRepositoryContract $productReviewRepository)
    {
        $this->productReviewRepository = $productReviewRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->productReviewRepository
            ->with(['createdBy', 'updatedBy'])
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function create($attributes = [])
    {
        $attributes['status'] = ProductReviewStatusEnum::PENDING;

        return $this->productReviewRepository->create($attributes);
    }

    public function show($id, $columns = ['*'])
    {
        return $this->productReviewRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return $this->productReviewRepository->update($attributes, $id);
    }

    public function delete($id)
    {
        return $this->productReviewRepository->delete($id);
    }

    public function allAvailable($data = [])
    {
        return $this->productReviewRepository
            ->modelScopes(['approved'])
            ->with(data_get($data, 'with', []))
            ->orderBy('created_at')
            ->all(data_get($data, 'columns', ['*']));
    }
}
