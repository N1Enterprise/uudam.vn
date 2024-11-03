<?php

namespace App\Repositories;

use App\Models\UserOrderShippingHistory;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\UserOrderShippingHistoryRepositoryContract;

class UserOrderShippingHistoryRepository extends BaseRepository implements UserOrderShippingHistoryRepositoryContract
{
    public function model()
    {
        return UserOrderShippingHistory::class;
    }
}
