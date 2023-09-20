<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StoreInventoryRequestContract;
use App\Enum\ActivationStatusEnum;
use Illuminate\Validation\Rule;

class StoreInventoryRequest extends BaseFormRequest implements StoreInventoryRequestContract
{
    public function rules(): array
    {
        dd($this->all());
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
