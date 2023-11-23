<?php

namespace App\Services;

use App\Common\ImageHelper;
use App\Enum\PaymentOptionTypeEnum;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\ExceptionCode;
use App\Repositories\Contracts\PaymentOptionRepositoryContract;
use Illuminate\Support\Facades\DB;

class PaymentOptionService extends BaseService
{
    public $paymentOptionRepository;
    public $paymentProviderService;

    public function __construct(PaymentOptionRepositoryContract $paymentOptionRepository, PaymentProviderService $paymentProviderService)
    {
        $this->paymentOptionRepository = $paymentOptionRepository;
        $this->paymentProviderService = $paymentProviderService;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->paymentOptionRepository
            ->with(['paymentProvider', 'systemCurrency'])
            ->appendIdSort()
            ->whereColumnsLike($data['query'] ?? null, ['name', 'currency_code', 'paymentProvider.name']);

        if ($currencyCode = data_get($data, 'currency_code')) {
            $result->where('currency_code', $currencyCode);
        }

        return $result->search([], null, ['*'], data_get($data, 'paginate', true));
    }

    public function searchByUser($data = [])
    {
        $result = $this->paymentOptionRepository
            ->modelScopes(['active', 'feDisplay'])
            ->with(['paymentProvider', 'systemCurrency'])
            ->scopeQuery(function($q) use ($data) {
                if ($currencyCode = data_get($data, 'currency_code')) {
                    $q->where('currency_code', $currencyCode);
                }
            });

        $result = $result->search([], null, ['*'], false);

        return $result;
    }

    public function show($id)
    {
        return $this->paymentOptionRepository->findOrFail($id);
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            if (PaymentOptionTypeEnum::isThirdParty($attributes['type'])) {
                $attributes['deposit_bank_id'] = null;
                $this->validatePaymentProviderCurrency($attributes['payment_provider_id'], $attributes['currency_code']);
            } else {
                $attributes['payment_provider_id'] = null;
                $attributes['online_banking_code'] = null;
            }

            $attributes['logo'] = ImageHelper::make('payment')->uploadImage(data_get($attributes, 'logo'));

            return $this->paymentOptionRepository->create($attributes);
        });
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function() use ($attributes, $id) {
            if (PaymentOptionTypeEnum::isThirdParty($attributes['type'])) {
                $this->validatePaymentProviderCurrency($attributes['payment_provider_id'], $attributes['currency_code']);
            } else {
                $attributes['payment_provider_id'] = null;
                $attributes['online_banking_code'] = null;
            }

            $attributes['logo'] = ImageHelper::make('payment')->uploadImage(data_get($attributes, 'logo'));

            return $this->paymentOptionRepository->update($attributes, $id);
        });
    }

    protected function validatePaymentProviderCurrency($id, $currencyCode)
    {
        $where = [
            'id' => $id,
        ];

        $paymentProvider = $this->paymentProviderService->firstWhereAndScope($where, ['active']);

        if (! $paymentProvider) {
            throw new BusinessLogicException('Invalid Payment Provider.', ExceptionCode::INVALID_PAYMENT_PROVIDER);
        }

        if (! in_array($currencyCode, $paymentProvider->supported_currencies)) {
            throw new BusinessLogicException('Invalid Payment Provider.', ExceptionCode::INVALID_PAYMENT_PROVIDER);
        }

        return $paymentProvider;
    }

}
