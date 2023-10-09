<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\StoreMenuRequestContract;

class StoreMenuRequest extends BaseFormRequest implements StoreMenuRequestContract
{
    public function rules(): array
    {
        return [

        ];
    }
}
