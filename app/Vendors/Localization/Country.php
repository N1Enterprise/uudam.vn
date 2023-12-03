<?php

namespace App\Vendors\Localization;

use Illuminate\Contracts\Container\BindingResolutionException;
use App\Models\Country as CountryEntity;
use App\Enum\ActivationStatusEnum;

class Country
{
    /**
     * @return static
     * @throws BindingResolutionException
     */
    public static function make()
    {
        return app(static::class);
    }

    /**
     * @return CountryEntity
     * @throws BindingResolutionException
     */
    public function model()
    {
        return app(CountryEntity::class);
    }

    public function all($data = [])
    {
        return $this->model()->query()
            ->orderBy(data_get($data, 'order_by', 'name'), data_get($data, 'sort_by', 'ASC'))
            ->where('status', ActivationStatusEnum::ACTIVE)
            ->get(array_merge(['id', 'name', 'iso2', 'currency'], data_get($data, 'columns', [])));
    }

    public function find($id)
    {
        return $this->model()->find($id);
    }

    public function findByCode($iso2)
    {
        return $this->model()->firstWhere('code', $iso2);
    }

    public function getStatesByCountry($countryId, $data = [])
    {
        // return State::query()
        //     ->when(is_numeric($countryId), function($q) use($countryId) {
        //         $q->where('country_id', $countryId);
        //     }, function($q) use($countryId) {
        //         $q->where('country_code', $countryId);
        //     })
        //     ->orderBy('name')
        //     ->get(['id', 'name', 'iso2']);
    }

    public function getCitiesByState($stateId, $data = [])
    {
        // return City::query()
        //     ->where('state_id', $stateId)
        //     ->orderBy('name')
        //     ->get(['id', 'name']);
    }

    public function findByIso2($iso2)
    {
        return $this->model()->firstWhere('iso2', $iso2);
    }

    public static function sanitizeCountries(array $countryCodes = [], array $acceptedCountryCodes = []): array
    {
        $countries = !empty($acceptedCountryCodes) ? $acceptedCountryCodes : self::make()->all()->pluck('id', 'iso2')->toArray();

        return array_filter($countryCodes, function($countryCode) use ($countries) {
            return $countries[$countryCode] ?? false;
        });
    }
}
