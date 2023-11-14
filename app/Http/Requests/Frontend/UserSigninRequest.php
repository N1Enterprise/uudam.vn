<?php

namespace App\Http\Requests\Frontend;

use App\Contracts\Requests\Frontend\UserSigninRequestContract;

class UserSigninRequest extends BaseFormRequest implements UserSigninRequestContract
{
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Vui lòng nhập e-mail hoặc số điện thoại.',
            'username.max' => 'E-mail hoặc số điện thoại không vượt quá 255 ký tự.',

            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu ít nhất 6 ký tự.',
            'password.max' => 'Mật khẩu không vượt quá 255 ký tự.',
        ];
    }
}
