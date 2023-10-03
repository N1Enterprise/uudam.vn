<?php

namespace App\Http\Requests\Frontend;

use App\Contracts\Requests\Frontend\SigninRequestContract;

class SigninRequest extends BaseFormRequest implements SigninRequestContract
{
    public function rules(): array
    {
        return [
            'phone_number' => ['required', 'regex:/^0[3-9]\d{8}$/'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }
}
