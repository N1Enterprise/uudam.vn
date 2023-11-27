<?php

namespace App\Services;

use App\Common\ImageHelper;
use App\Enum\ShippingRateTypeEnum;
use App\Repositories\Contracts\CarrierRepositoryContract;
use App\Services\BaseService;
use App\Vendors\Localization\Money;
use Illuminate\Support\Facades\DB;

class CarrierService extends BaseService
{
    public $carrierRepository;
    public $shippingRateService;
    public $cartService;

    public function __construct(
        CarrierRepositoryContract $carrierRepository,
        ShippingRateService $shippingRateService,
        CartService $cartService
    ) {
        $this->carrierRepository = $carrierRepository;
        $this->shippingRateService = $shippingRateService;
        $this->cartService = $cartService;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->carrierRepository
            ->whereColumnsLike($data['query'] ?? null, ['name', 'email', 'phone'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->carrierRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return DB::transaction(function() use ($attributes) {
            if ($logo = data_get($attributes, 'logo')) {
                $attributes['logo'] = ImageHelper::make('shipping')->uploadImage($logo);
            }

            return $this->carrierRepository->create($attributes);
        });
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function() use ($attributes, $id) {
            if ($logo = data_get($attributes, 'logo')) {
                $attributes['logo'] = ImageHelper::make('shipping')->uploadImage($logo);
            }

            return $this->carrierRepository->update($attributes, $id);
        });
    }

    public function show($id, $data = [])
    {
        return $this->carrierRepository
            ->with(data_get($data, 'with', []))
            ->findOrFail($id, data_get($data, 'columns', ['*']));
    }

    public function searchCarrierShippingRatePriceGroupedByCart($cartId, $data = [])
    {
        $cart = $this->cartService->show($cartId);

        $shippingRates = $this->shippingRateService->searchByUser([
            'type' => ShippingRateTypeEnum::PRICE,
            'value' => Money::make($cart->total_price, $cart->currency_code)->toFloat(),
        ]);

        $shippingRatesCarriers = collect($shippingRates)->groupBy('carrier.id')->map(function ($group) use ($cart) {
            $carrier = data_get($group->first(), 'carrier');

            $shippingRates = $group ->map(function ($item) use ($cart) {
                return array_merge(
                    optional($item)->only(['id', 'name', 'delivery_takes', 'rate']),
                    [
                        'total_price_has_shipping' => Money::make($cart->total_price, $cart->currency_code)
                            ->plus(data_get($item, 'rate', 0))
                            ->__toString()
                    ]
                );
            })->all();

            return [
                'carrier_id'   => data_get($carrier, 'id'),
                'carrier_name' => data_get($carrier, 'name'),
                'carrier_logo' => data_get($carrier, 'logo'),
                'shipping_rates' => $shippingRates,
            ];
        })
        ->values()
        ->all();

        return $shippingRatesCarriers;
    }
}
