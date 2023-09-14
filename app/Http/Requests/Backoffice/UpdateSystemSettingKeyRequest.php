<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\ValidationException;
use App\Contracts\Requests\Backoffice\UpdateSystemSettingKeyRequestContract;
use App\Enum\SystemSettingValueTypeEnum;
use App\Models\SystemSetting;
use App\Elements\BaseElement;

class UpdateSystemSettingKeyRequest extends BaseFormRequest implements UpdateSystemSettingKeyRequestContract
{
    public function rules(): array
    {
        $rules = [];
        $settingKey = $this->key;

        /** @var BaseElement */
        $settingElement = SystemSetting::from($settingKey);

        $valueType = $settingElement->valueType();

        if (! $valueType) {
            throw new ValidationException(__('Undefined value type.'));
        }

        switch ($valueType) {
            case SystemSettingValueTypeEnum::BOOL_TYPE:
                $rules['value'] = ['boolean'];
                break;
            case SystemSettingValueTypeEnum::NUMBER_TYPE:
                $rules['value'] = ['numeric', 'nullable'];
                break;
            case SystemSettingValueTypeEnum::STRING_TYPE:
                $rules['value'] = ['nullable'];
                break;
            case SystemSettingValueTypeEnum::JSON_TYPE:
                $rules['value'] = ['array', 'nullable'];
                break;
            case SystemSettingValueTypeEnum::DATE_TIME_TYPE:
                $rules['value'] = ['date', 'nullable'];
                break;
            default:
                $rules['value'] = ['nullable'];
                break;
        }

        $rules['key'] = ['required'];

        return $rules;
    }

    public function prepareForValidation()
    {
        /** @var BaseElement */
        $settingElement = SystemSetting::from($this->key);

        $valueType = $settingElement->valueType();
        $valueCasted = $this->value;

        if (! $valueType) {
            return;
        }

        switch ($valueType) {
            case SystemSettingValueTypeEnum::BOOL_TYPE:
                $valueCasted = $this->boolean('value');
                break;
            case SystemSettingValueTypeEnum::JSON_TYPE:
                $valueCasted = json_decode($this->value, true);
                break;
            case SystemSettingValueTypeEnum::DATE_TIME_TYPE:
                $valueCasted = $this->value ? convert_datetime_to_client_time($this->value, true) : null;
                break;
            default:
                break;
        }

        $this->merge([
            'key' => $this->key,
            'value' => $valueCasted,
        ]);
    }
}
