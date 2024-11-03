<?php

namespace App\Http\Resources\Backoffice;

use App\Common\Money;
use App\Enum\ShippingRateTypeEnum;
use Illuminate\Support\Facades\Route;

class ShippingRateResource extends BaseJsonResource
{
    public function toArray($request)
    {
        $minimumFormatted = null;
        $maximumFormatted = null;

        if ($this->type == ShippingRateTypeEnum::PRICE) {
            $minimumFormatted = $this->minimum != null ? $this->toMoney('minimum')->format() : null;
            $maximumFormatted = $this->maximum != null ? $this->toMoney('maximum')->format() : null;
        }

        if ($this->type == ShippingRateTypeEnum::WEIGHT) {
            $minimumFormatted = $this->minimum != null ?  round($this->minimum, 2).'(g)' : null;
            $maximumFormatted = $this->maximum != null ?  round($this->maximum, 2).'(g)' : null;
        }

        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'shipping_zone_id' => $this->shipping_zone_id,
            'carrier_id' => $this->carrier_id,
            'delivery_takes' => $this->delivery_takes,
            'type' => $this->type,
            'type_name' => $this->type_name,
            'minimum' => $this->minimum,
            'minimum_formatted' => $minimumFormatted,
            'maximum' => $this->maximum,
            'maximum_formatted' => $maximumFormatted,
            'rate' => $this->rate,
            'rate_formatted' => $this->rate == 0 ? __('Free Ship') : $this->toMoney('rate')->format(),
            'status' => $this->status,
            'status_name' => $this->status_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'shipping_zone' => $this->whenLoaded('shippingZone', function() {
                return optional($this->shippingZone)->only(['id', 'name']);
            }),
            'carrier' => $this->whenLoaded('carrier', function() {
                return optional($this->carrier)->only(['id', 'name']);
            }),
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $updatePermission = $this->getPermissionByAction('update');
        $deletePermission = $this->getPermissionByAction('delete');

        return array_filter([
            'actions' => array_filter([
                'update' => $updatePermission ? Route::findByName('bo.web.shipping-rates.edit', ['id' => $this->getKey()]) : null,
                'delete' => $deletePermission ? Route::findByName('bo.web.shipping-rates.delete', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
