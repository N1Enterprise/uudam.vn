<?php

namespace App\Http\Requests\Frontend;

use App\Contracts\Requests\Frontend\UserCancelOrderRequestContract;
use App\Enum\SystemSettingKeyEnum;
use App\Models\SystemSetting;
use Illuminate\Validation\Rule;

class UserCancelOrderRequest extends BaseFormRequest implements UserCancelOrderRequestContract
{
    public function rules(): array
    {
        $orderCancelReasons = SystemSetting::from(SystemSettingKeyEnum::ORDER_CANCEL_REASONS)->get(null, []);

        $orderCancelCodes = [];

        foreach ($orderCancelReasons as $reason) {
            $orderCancelCodes[] = data_get($reason, 'code');
        }

        return [
            'reason' => ['required', 'string', 'max:255', Rule::in($orderCancelCodes)],
            'content' => ['required', 'string', 'max:255'],
        ];
    }
}
