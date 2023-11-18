<?php

namespace App\Http\Resources\Backoffice;

class CountryResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'iso3' => $this->iso3,
            'numeric_code' => $this->numeric_code,
            'iso2' => $this->iso2,
            'phonecode' => $this->phonecode,
            'capital' => $this->capital,
            'currency' => $this->currency,
            'currency_name' => $this->currency_name,
            'currency_symbol' => $this->currency_symbol,
            'tld' => $this->tld,
            'native' => $this->native,
            'region' => $this->region,
            'subregion' => $this->subregion,
            'timezones' => $this->timezones,
            'translations' => $this->translations,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'emoji' => $this->emoji,
            'emojiU' => $this->emojiU,
            'flag' => $this->flag,
            'wikiDataId' => $this->wikiDataId,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        return [];
    }
}
