<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateSystemSettingGroupRequestContract;

class UpdateSystemSettingGroupRequest extends BaseFormRequest implements UpdateSystemSettingGroupRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'value' => ['required'],
        ];
    }
}
