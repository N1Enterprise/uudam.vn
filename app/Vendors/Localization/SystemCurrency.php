<?php

namespace App\Vendors\Localization;

use App\Services\SystemCurrencyService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;
use App\Common\Cache;
use App\Exceptions\BusinessLogicException;
use App\Models\SystemCurrency as SystemCurrencyEntity;
use App\Enum\CurrencyTypeEnum;

class SystemCurrency
{
    public static $_cachedCurrencies = [];

    public $systemCurrencyService;

    public function __construct(SystemCurrencyService $systemCurrencyService) {
        $this->systemCurrencyService = $systemCurrencyService;
    }
    /**
     * @return static
     * @throws BindingResolutionException
     */
    public static function make()
    {
        return app(static::class);
    }


    /**
     * @param string $currencyCode
     * @return SystemCurrencyEntity
     * @throws BindingResolutionException
     * @throws BusinessLogicException
     */
    public static function get($currencyCode, $fallbackDefaultCurrency = false, $throwException = true)
    {
        if ($currencyCode instanceof SystemCurrencyEntity) {
            return $currencyCode;
        }

        if (!blank(static::getCachedCurrencies())) {
            $currency = collect(static::getCachedCurrencies())->firstWhere('key', $currencyCode);
        } else {
            $currency = Cache::tags(SystemCurrencyEntity::CACHE_TAG)
                ->rememberForever($currencyCode, function () use($currencyCode, $fallbackDefaultCurrency) {
                    $currency = self::make()->systemCurrencyService->find($currencyCode);

                    return $currency;
                });
        }

        if (!$currency && $fallbackDefaultCurrency) {
            $currency = self::make()->systemCurrencyService->getBaseCurrency() ?? self::make()->systemCurrencyService->getDefaultCurrency();
        }

        /** @var SystemCurrencyEntity */
        if ($throwException && !$currency) {
            throw new BusinessLogicException('Invalid currency with key:'. $currencyCode);
        }

        return $currency;
    }

    public static function clearCache()
    {
        Cache::tags(SystemCurrencyEntity::CACHE_TAG)->flush();
        Cache::forget(SystemCurrencyEntity::CACHE_TAG);

        static::$_cachedCurrencies = [];
    }

    /**
     * Get all currency code
     *
     * @return SystemCurrencyEntity[]|Collection
     */
    public static function all()
    {
        return collect(static::getCachedCurrencies());
    }

    public static function getCachedCurrencies()
    {
        if (app()->runningInConsole()) {
            return Cache::rememberForever(SystemCurrencyEntity::CACHE_TAG, function () {
                return static::make()->systemCurrencyService->allAvailable();
            });
        }

        if (blank(static::$_cachedCurrencies)) {
            static::$_cachedCurrencies = Cache::rememberForever(SystemCurrencyEntity::CACHE_TAG, function () {
                return static::make()->systemCurrencyService->allAvailable();
            });
        }

        return collect(static::$_cachedCurrencies);
    }

    public static function allConfigurable()
    {
        return static::all()->where('usable', true);
    }

    public static function allFiatConfigurable()
    {
        return static::allFiat()->where('is_base', true);
    }

    public static function allFiat()
    {
        return static::all()->where('type', CurrencyTypeEnum::FIAT);
    }

    /**
     * Get default currency
     *
     * @return SystemCurrencyEntity
     */
    public static function getDefaultCurrency()
    {
        return static::all()->where('is_default', true)->first();
    }

    /**
     * Get base currency
     *
     * @return SystemCurrencyEntity
     */
    public static function getBaseCurrency()
    {
        return static::all()->where('is_base', true)->first();
    }

    public static function getActiveCurrencyByCountryCode($countryCode, $fallbackDefaultCurrency = false)
    {
        $defaultCurrency  = self::getDefaultCurrency();

        if(!$countryCode && $fallbackDefaultCurrency) {
            return $defaultCurrency;
        }

        $currency = self::get(optional(Currency::make()->findByCountry($countryCode))->code, $fallbackDefaultCurrency);

        if ((!$currency || !$currency->isActive()) && $fallbackDefaultCurrency) {
            $currency = $defaultCurrency;
        }

        return $currency;

    }

    public static function allPreferredCurrencies()
    {
        return static::all()->where('type', CurrencyTypeEnum::FIAT);
    }
}
