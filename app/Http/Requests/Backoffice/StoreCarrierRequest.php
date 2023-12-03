<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StoreCarrierRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Models\Carrier;
use App\ValidationRules\PhoneNumberValidate;
use Illuminate\Validation\Rule;

class StoreCarrierRequest extends BaseFormRequest implements StoreCarrierRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique(Carrier::class, 'email')],
            'phone' => ['nullable', Rule::unique(Carrier::class, 'phone'), new PhoneNumberValidate],
            'logo' => ['nullable', 'array'],
            'logo.file' => ['nullable', 'file', 'image', 'max:5200'],
            'logo.path' => ['nullable', 'string'],
            'params' => ['nullable'],
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
