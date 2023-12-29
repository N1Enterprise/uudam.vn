<?php

namespace App\Services;

use App\Cms\ProductReviewCms;
use App\Enum\ProductReviewStatusEnum;
use App\Exceptions\BusinessLogicException;
use App\Repositories\Contracts\ProductReviewRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Arr;

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
            ->with(['createdBy', 'updatedBy', 'product'])
            ->scopeQuery(function($q) use ($data) {
                $statuses = Arr::wrap(data_get($data, 'status', []));

                if (! empty($statuses)) {
                    $q->whereIn('status', $statuses);
                }

                $ratingTypes = Arr::wrap(data_get($data, 'rating_type', []));

                if (! empty($ratingTypes)) {
                    $q->whereIn('rating_type', $ratingTypes);
                }

                $isRealUser = data_get($data, 'is_real_user', 0);

                if (boolean($isRealUser)) {
                    $q->where('is_real_user', 1);
                }

                $productId = data_get($data, 'product_id');

                if (! empty($productId)) {
                    $q->whereHas('product', function($q) use ($productId) {
                        $q->where('id', $productId);
                    });
                }
            })
            ->whereColumnsLike($data['query'] ?? null, ['user_name', 'user_phone', 'user_email'])
            ->search([]);

        return $result;
    }

    public function create($attributes = [])
    {
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
        $productReview = $this->show($id);

        if ($productReview->is_real_user) {
            throw new BusinessLogicException('Your registration request is pending.');
        }

        return $this->productReviewRepository->delete($id);
    }

    public function approve($id)
    {
        $productReview = $this->show($id);

        $this->productReviewRepository->update(['status' => ProductReviewStatusEnum::APPROVED], $productReview);

        ProductReviewCms::flush();
    }

    public function decline($id)
    {
        $productReview = $this->show($id);

        $this->productReviewRepository->update(['status' => ProductReviewStatusEnum::DECLINED], $productReview);

        ProductReviewCms::flush();
    }
}
