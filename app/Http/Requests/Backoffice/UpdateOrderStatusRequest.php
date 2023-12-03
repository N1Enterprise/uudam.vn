<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateOrderStatusRequestContract;
use App\Enum\OrderStatusEnum;
use App\Enum\PaymentStatusEnum;
use Illuminate\Validation\Rule;

class UpdateOrderStatusRequest extends BaseFormRequest implements UpdateOrderStatusRequestContract
{
    public function rules(): array
    {
        return [
            'order_status' => ['nullable', 'integer', Rule::in(OrderStatusEnum::all())],
            'payment_status' => ['nullable', 'integer', Rule::in(PaymentStatusEnum::all())],
            'admin_note' => ['nullable', 'string']
        ];
    }
}
