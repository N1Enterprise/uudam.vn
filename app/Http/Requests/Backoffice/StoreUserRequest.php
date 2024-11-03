<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\StoreUserRequestContract;
use App\Enum\AccessChannelType;
use App\Enum\ActivationStatusEnum;
use App\Models\User;
use App\ValidationRules\PhoneNumberValidate;
use App\Vendors\Localization\SystemCurrency;

class StoreUserRequest extends BaseFormRequest implements StoreUserRequestContract
{
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'alpha-dash', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique(User::class)],
            'password' => ['nullable', 'string', 'min:6', 'max:255'],
            'status' => ['required', Rule::in(ActivationStatusEnum::all())],
            'currency_code' => ['required', 'string', Rule::in(SystemCurrency::all()->pluck('code'))],
            'is_test_user' => ['required', 'boolean'],
            'phone_number' => ['nullable', new PhoneNumberValidate],
            'birthday' => ['nullable', 'date'],
            'access_channel_type' => ['required', Rule::in(AccessChannelType::all())],
            'meta' => ['nullable', 'array'],
            'allow_login' => ['required', 'boolean']
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => boolean($this->status) ? ActivationStatusEnum::ACTIVE : ActivationStatusEnum::INACTIVE,
            'allow_login' => boolean($this->allow_login),
            'is_test_user' => boolean($this->is_test_user),
        ]);
    }
}
