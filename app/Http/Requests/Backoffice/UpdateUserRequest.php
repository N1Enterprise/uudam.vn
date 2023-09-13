<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\UpdateUserRequestContract;
use App\Models\User;

class UpdateUserRequest extends BaseFormRequest implements UpdateUserRequestContract
{
    public function rules(): array
    {
        return [
            'email'        => ['required', 'email', Rule::unique(User::class)->ignore($this->route('id'))],
            'phone_number' => ['nullable', 'phone:auto', Rule::unique(User::class, 'phone_number')->ignore($this->route('id'))],
            'country_id'   => ['nullable', Rule::exists('countries', 'id')],
            'state_id'     => ['nullable', Rule::exists('states', 'id')->where('country_id', $this->country_id)],
            'city_id'      => ['nullable', Rule::exists('cities', 'id')->where('state_id', $this->state_id)],
            'address'      => ['nullable'],
            'post_code'    => ['nullable', 'string', 'min:2', 'max:10'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'phone_number' => (string) phone($this->get('phone_number')),
        ]);
    }
}
