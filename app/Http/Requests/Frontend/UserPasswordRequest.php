<?php

namespace App\Http\Requests\Frontend;

use App\Contracts\Requests\Frontend\UserPasswordRequestContract;

class UserPasswordRequest extends BaseFormRequest implements UserPasswordRequestContract
{
    public function rules(): array
    {
        return [
            'password' => ['required', 'string', 'min:6', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu ít nhất 6 ký tự.',
            'password.max' => 'Mật khẩu không vượt quá 255 ký tự.',
        ];
    }
}
