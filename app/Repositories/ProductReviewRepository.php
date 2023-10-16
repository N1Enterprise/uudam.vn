<?php

namespace App\Repositories;

use App\Models\ProductReview;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ProductReviewRepositoryContract;

class ProductReviewRepository extends BaseRepository implements ProductReviewRepositoryContract
{
    public function model()
    {
        return ProductReview::class;
    }
}
