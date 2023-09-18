<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateProductRequestContract;

class UpdateProductRequest extends BaseFormRequest implements UpdateProductRequestContract
{
    public function rules(): array
    {
        return [
        ];
    }
}
