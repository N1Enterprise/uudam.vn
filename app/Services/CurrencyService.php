<?php

namespace App\Services;

use App\Repositories\Contracts\CurrencyRepositoryContract;
use App\Services\BaseService;

class CurrencyService extends BaseService
{
    public $currencyRepository;

    public function __construct(CurrencyRepositoryContract $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->currencyRepository
            ->whereColumnsLike($data['query'] ?? null, ['name', 'code'])
            ->search([]);

        return $result;
    }
}
