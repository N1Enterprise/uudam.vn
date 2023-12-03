<?php

namespace App\Services;

use App\Repositories\Contracts\CountryRepositoryContract;
use App\Services\BaseService;

class CountryService extends BaseService
{
    public $countryRepository;

    public function __construct(CountryRepositoryContract $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->countryRepository
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }
}
