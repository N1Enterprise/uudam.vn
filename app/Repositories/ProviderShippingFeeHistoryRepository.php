<?php

namespace App\Repositories;

use App\Models\ProviderShippingFeeHistory;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ProviderShippingFeeHistoryRepositoryContract;

class ProviderShippingFeeHistoryRepository extends BaseRepository implements ProviderShippingFeeHistoryRepositoryContract
{
    public function model()
    {
        return ProviderShippingFeeHistory::class;
    }
}
