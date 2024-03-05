<?php

namespace App\Services;

use App\Repositories\Contracts\UserOrderShippingHistoryRepositoryContract;
use App\Services\BaseService;

class UserOrderShippingHistoryService extends BaseService
{
    public $userOrderShippingHistoryRepositoryContract;

    public function __construct(UserOrderShippingHistoryRepositoryContract $userOrderShippingHistoryRepositoryContract) 
    {
        $this->userOrderShippingHistoryRepositoryContract = $userOrderShippingHistoryRepositoryContract;
    }

    public function create($attributes = [])
    {
        return $this->userOrderShippingHistoryRepositoryContract->create($attributes);
    }

    public function update($attributes = [], $id)
    {
        return $this->userOrderShippingHistoryRepositoryContract->update($attributes, $id);
    }

    public function show($id)
    {
        return $this->userOrderShippingHistoryRepositoryContract->findOrFail($id);
    }
}
