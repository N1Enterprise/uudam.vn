<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateInventoryRequestContract;
use App\Enum\ActivationStatusEnum;
use Illuminate\Validation\Rule;

class UpdateInventoryRequest extends BaseFormRequest implements UpdateInventoryRequestContract
{
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
        ];
    }


    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
        ]);
    }
}
