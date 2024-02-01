<?php

namespace App\Services;

use App\Repositories\Contracts\ProviderShippingFeeHistoryRepositoryContract;
use App\Services\BaseService;

class ProviderShippingFeeHistoryService extends BaseService
{
    public $providerShippingFeeHistoryRepository;

    public function __construct(ProviderShippingFeeHistoryRepositoryContract $providerShippingFeeHistoryRepository)
    {
        $this->providerShippingFeeHistoryRepository = $providerShippingFeeHistoryRepository;
    }

    public function firstOrCreate($attributes = [], $values = [])
    {
        return $this->providerShippingFeeHistoryRepository->firstOrCreate($attributes, $values);
    }
}
