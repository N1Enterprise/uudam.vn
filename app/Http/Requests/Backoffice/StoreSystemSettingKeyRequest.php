<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\StoreSystemSettingKeyRequestContract;
use App\Enum\SystemSettingValueTypeEnum;
use App\Models\SystemSetting;

class StoreSystemSettingKeyRequest extends BaseFormRequest implements StoreSystemSettingKeyRequestContract
{
    public function rules(): array
    {
        return [
            'key' => ['regex:/^(?=.*[a-zA-Z]).+$/', 'alpha-dash', Rule::unique(SystemSetting::class)],
            'group_id' => ['required'],
            'value_type' => ['required'],
            'label' => ['required'],
            'value' => ['nullable']
        ];
    }

    public function prepareForValidation()
    {
        if ($this->value_type == SystemSettingValueTypeEnum::BOOL_TYPE) {
            $this->merge(['value' => false]);
        }
    }
}
