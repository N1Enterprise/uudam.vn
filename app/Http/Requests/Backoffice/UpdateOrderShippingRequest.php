<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateOrderShippingRequestContract;
use App\Models\ShippingProvider;
use App\Models\UserOrderShippingHistory;
use Illuminate\Validation\Rule;

class UpdateOrderShippingRequest extends BaseFormRequest implements UpdateOrderShippingRequestContract
{
    public function rules(): array
    {
        return [
            'user_order_shipping_history_id' => ['required', Rule::exists(UserOrderShippingHistory::class, 'id')],
            'shipping_provider_id' => ['required', Rule::exists(ShippingProvider::class, 'id')],
            'transport_fee' => ['nullable', 'numeric'],
            'reference_id' => ['nullable', 'string', 'max:255'],
        ];
    }
}
