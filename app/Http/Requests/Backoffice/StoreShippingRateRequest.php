<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StoreShippingRateRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Enum\ShippingRateTypeEnum;
use App\Models\ShippingZone;
use Illuminate\Validation\Rule;

class StoreShippingRateRequest extends BaseFormRequest implements StoreShippingRateRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'shipping_zone_id' => ['required', 'integer', Rule::exists(ShippingZone::class, 'id')],
            'delivery_takes' => ['required', 'string', 'max:255'],
            'type' => ['required', 'integer', Rule::in(ShippingRateTypeEnum::all())],
            'minimum' => ['required'],
            'maximum' => ['nullable', 'gt:minimum'],
            'rate' => ['required'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'display_on_frontend' => ['required']
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'display_on_frontend' => boolean($this->display_on_frontend)
        ]);
    }
}
