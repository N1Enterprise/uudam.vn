<?php

namespace App\Http\Requests\Frontend;

use App\Contracts\Requests\Frontend\UserSignupRequestContract;
use App\Enum\ActivationStatusEnum;
use App\Models\User;
use App\Services\UserService;
use App\ValidationRules\PhoneNumberValidate;
use Illuminate\Validation\Rule;

class UserSignupRequest extends BaseFormRequest implements UserSignupRequestContract
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:20'],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class, 'username')],
            'phone_number' => ['required', 'string', 'max:15', Rule::unique(User::class, 'phone_number'), new PhoneNumberValidate()],
            'email' => ['required', 'email', 'string', 'max:255', Rule::unique(User::class, 'email')],
            'password' => ['required', 'string', 'min:6', 'max:255'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'username' => UserService::make()->generateUsername(8),
            'status' => ActivationStatusEnum::ACTIVE,
        ]);
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

            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu ít nhất 6 ký tự.',
            'password.max' => 'Mật khẩu không vượt quá 255 ký tự.',
        ];
    }
}
