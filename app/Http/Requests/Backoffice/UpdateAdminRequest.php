<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateAdminRequestContract;

class UpdateAdminRequest extends BaseFormRequest implements UpdateAdminRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'password' => ['nullable', 'min:6'],
            'roles' => ['required', 'array', 'min:1'],
        ];
    }
}
