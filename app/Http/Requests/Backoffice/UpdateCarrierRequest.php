<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateCarrierRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Models\Carrier;
use App\ValidationRules\PhoneNumberValidate;
use Illuminate\Validation\Rule;

class UpdateCarrierRequest extends BaseFormRequest implements UpdateCarrierRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique(Carrier::class, 'email')->ignore($this->route('id'))],
            'phone' => ['nullable', Rule::unique(Carrier::class, 'phone')->ignore($this->route('id')), new PhoneNumberValidate],
            'params' => ['nullable'],
            'logo' => ['required', 'array'],
            'logo.file' => ['nullable', 'file', 'image', 'max:5200'],
            'logo.path' => ['nullable', 'string'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'params' => !empty($this->params) ? json_decode($this->params) : null,
            'logo' => empty(array_filter($this->logo)) ? null : array_filter($this->logo),
        ]);
    }
}
