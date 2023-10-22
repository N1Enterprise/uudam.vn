<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateAdminPasswordRequestContract;

class UpdateAdminPasswordRequest extends BaseFormRequest implements UpdateAdminPasswordRequestContract
{
    public function rules(): array
    {
        return [
            'password' => ['required', 'current_password:admin'],
            'new_password' => ['required'],
        ];
    }
}
