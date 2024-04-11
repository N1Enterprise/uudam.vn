<?php

namespace App\Http\Requests\Frontend;

use App\Classes\Contracts\UserAuthContract;
use App\Contracts\Requests\Frontend\UserUpdateInfoRequestContract;
use App\Models\User;
use App\ValidationRules\PhoneNumberValidate;
use Illuminate\Validation\Rule;

class UserUpdateInfoRequest extends BaseFormRequest implements UserUpdateInfoRequestContract
{
    public function rules(): array
    {
        /** @var User */
        $user = app(UserAuthContract::class)->user();

        return [
            'name' => ['required', 'string', 'max:20'],
            'phone_number' => [
                'required',
                'string',
                'max:15',
                // Rule::unique(User::class, 'phone_number')->ignore($user->getKey()),
                new PhoneNumberValidate()
            ],
            'email' => ['nullable', 'email', 'string', 'max:255', Rule::unique(User::class, 'email')->ignore($user->getKey())],
            'birthday' => ['nullable', 'date']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập số điện thoại.',
            'name.max' => 'Số kí tự số điện thoại không vượt quá 20 ký tự.',

            'phone_number.required' => 'Vui lòng nhập số điện thoại.',
            'phone_number.max' => 'Số kí tự số điện thoại không vượt quá 15 ký tự.',
            'phone_number.unique' => 'Số điện thoại đã tồn tại.',

            'email.required' => 'Vui lòng nhập E-Mail.',
            'email.max' => 'Số kí tự E-Mail không vượt quá 255 ký tự.',
            'email.unique' => 'E-Mail đã tồn tại.',
        ];
    }
}
