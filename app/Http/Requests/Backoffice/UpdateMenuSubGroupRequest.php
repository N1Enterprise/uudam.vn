<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateMenuSubGroupRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Models\MenuGroup;
use Illuminate\Validation\Rule;

class UpdateMenuSubGroupRequest extends BaseFormRequest implements UpdateMenuSubGroupRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'menu_group_id' => ['required', 'integer', Rule::exists(MenuGroup::class, 'id')],
            'redirect_url' => ['required', 'string', 'max:255'],
            'order' => ['required', 'integer'],
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
