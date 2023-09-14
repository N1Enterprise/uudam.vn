<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\UpdateSystemSettingRequestContract;

class UpdateSystemSettingRequest extends BaseFormRequest implements UpdateSystemSettingRequestContract
{
    public function rules(): array
    {
        return [
            'group_id' => [
                'required',
                Rule::exists('system_setting_groups', 'id')
            ],
            'label' => ['nullable'],
            'order' => ['required', 'integer'],
        ];
    }
}
