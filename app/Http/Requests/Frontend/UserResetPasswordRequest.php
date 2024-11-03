<?php

namespace App\Http\Requests\Frontend;

use App\Contracts\Requests\Frontend\UserResetPasswordRequestContract;

class UserResetPasswordRequest extends BaseFormRequest implements UserResetPasswordRequestContract
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'token' => ['required'],
            'password' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'E-mail không tồn tại.',
            'token.required' => 'Token không tồn tại.',
        ];
    }
}
