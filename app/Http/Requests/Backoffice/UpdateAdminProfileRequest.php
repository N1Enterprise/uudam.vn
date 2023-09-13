<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateAdminProfileRequestContract;

class UpdateAdminProfileRequest extends BaseFormRequest implements UpdateAdminProfileRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
        ];
    }
}
