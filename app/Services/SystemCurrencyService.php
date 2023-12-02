<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Exceptions\BusinessLogicException;
use App\Repositories\Contracts\SystemCurrencyRepositoryContract;

class SystemCurrencyService extends BaseService
{
    public $systemCurrencyRepository;

    public function __construct(SystemCurrencyRepositoryContract $systemCurrencyRepository)
    {
        $this->systemCurrencyRepository = $systemCurrencyRepository;
    }

    public function show($key)
    {
        return $this->systemCurrencyRepository->findOrFail($key);
    }

    public function find($key)
    {
        return $this->systemCurrencyRepository->find($key);
    }

    public function searchByAdmin($data = [])
    {
        return $this->systemCurrencyRepository
            ->with(['createdBy', 'updatedBy'])
            ->whereColumnsLike(data_get($data, 'query'), ['key', 'name', 'code'])
            ->scopeQuery(function ($q) use ($data) {
                if ($type = data_get($data, 'type', [])) {
                    $q->where('type', $type);
                }
            })
            ->search([]);
    }

    public function allAvailable($where = [])
    {
        return $this->systemCurrencyRepository->modelScopes(['active', 'ordered'])->findWhere($where);
    }

    public function create($attributes = [])
    {
        $attributes['key'] = data_get($attributes, 'key', data_get($attributes, 'code'));

        return $systemCurrency = $this->systemCurrencyRepository->create($attributes);

        return $systemCurrency;
    }

    public function update($key, $attributes = [])
    {
        return DB::transaction(function($q) use($attributes, $key) {
            $systemCurrency = $this->systemCurrencyRepository->update($attributes, $key);

            if(! $systemCurrency->isActive() && $systemCurrency->is_default) {
                throw new BusinessLogicException('Unable to deactivate default currency.');
            }

            return $systemCurrency;
        });
    }

    public function getDefaultCurrency()
    {
        return $this->systemCurrencyRepository->firstWhere([
            'is_default' => 1,
        ]);
    }

    public function getBaseCurrency()
    {
        return $this->systemCurrencyRepository->firstWhere([
            'is_base' => 1,
        ]);
    }

    public function markAsDefault($key)
    {
        $systemCurrency = $this->show($key);

        if ($systemCurrency->is_default) {
            return $systemCurrency;
        }

        if(! $systemCurrency->isActive()) {
            throw new BusinessLogicException('The currency was not able to be default system currency due to deactivated status.');
        }

        return DB::transaction(function () use ($systemCurrency) {
            $this->systemCurrencyRepository->getNewModel()->query()
                ->where('is_default', true)
                ->where('key', '<>', $systemCurrency->getKey())
                ->update(['is_default' => false]);

            return $this->update($systemCurrency->getKey(), [
                'is_default' => true,
            ]);
        });
    }

    public function markAsBase($key)
    {
        $systemCurrency = $this->show($key);

        if ($systemCurrency->is_base) {
            return $systemCurrency;
        }

        if (! $systemCurrency->isActive()) {
            throw new BusinessLogicException('The currency was not able to be base system currency due to deactivated status.');
        }

        return DB::transaction(function () use ($systemCurrency) {
            $this->systemCurrencyRepository->getNewModel()->query()
                ->where('is_base', true)
                ->where('key', '<>', $systemCurrency->getKey())
                ->update(['is_base' => false]);

            return $this->update($systemCurrency->getKey(), [
                'is_base' => true,
            ]);
        });
    }
}
