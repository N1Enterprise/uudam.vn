<?php

namespace App\Services;

use App\Repositories\Contracts\PaymentProviderRepositoryContract;

class PaymentProviderService extends BaseService
{
    public $paymentProviderRepository;

    public function __construct(PaymentProviderRepositoryContract $paymentProviderRepository)
    {
        $this->paymentProviderRepository = $paymentProviderRepository;
    }

    public function all($data = [''])
    {
        return $this->paymentProviderRepository->modelScopes('active')->all(data_get($data, 'columns', ['*']));
    }

    public function getProviderByType($type)
    {
        return $this->paymentProviderRepository->modelScopes('active')->where('payment_type', $type)->get();
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->paymentProviderRepository
            ->whereColumnsLike($data['query'] ?? null, ['name', 'code'])
            ->search();

        return $result;
    }

    public function show($id)
    {
        return $this->paymentProviderRepository->findOrFail($id);
    }

    public function firstWhereAndScope($where, $scopes = [])
    {
        return $this->paymentProviderRepository->modelScopes($scopes)->firstWhere($where);
    }

    public function create($attributes = [])
    {
        $paymentProvider = $this->paymentProviderRepository->create($attributes);

        return $paymentProvider;
    }

    public function update($attributes = [], $id)
    {
        $paymentProvider = $this->paymentProviderRepository->update($attributes, $id);

        return $paymentProvider;
    }

    public function getActivePaymentProvider($condition = [])
    {
        return $this->paymentProviderRepository
            ->active()
            ->where($condition)
            ->first();
    }
}
