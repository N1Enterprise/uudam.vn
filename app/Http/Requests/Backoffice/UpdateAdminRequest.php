<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateAdminRequestContract;

class UpdateAdminRequest extends BaseFormRequest implements UpdateAdminRequestContract
{
    public function rules(): array
    {
        $rules = [
            'name' => ['required'],
            'password' => ['nullable', 'min:6'],
        ];

        if (is_webmaster()) {
            $rules['roles'] = ['required', 'array', 'min:1'];
        }

        return $rules;
    }
}
