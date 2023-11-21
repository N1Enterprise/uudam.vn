<?php

namespace App\Http\Resources\Backoffice;

class CurrencyResource extends BaseJsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'symbol' => $this->symbol,
            'decimals' => $this->decimals,
            'used_countries' => $this->used_countries,
            'type' => $this->type,
            'type_name' => $this->type_name,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
