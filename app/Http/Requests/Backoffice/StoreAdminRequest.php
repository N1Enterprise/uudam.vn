<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Validation\Rule;
use App\Contracts\Requests\Backoffice\StoreAdminRequestContract;
use App\Models\Admin;

class StoreAdminRequest extends BaseFormRequest implements StoreAdminRequestContract
{
    public function rules(): array
    {
        return [
            'email' => ['required', Rule::unique(Admin::class), 'email'],
            'name' => ['required'],
            'password' => ['required', 'min:6'],
            'roles' => ['required', 'array', 'min:1'],
        ];
    }
}
