<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\DeclineDepositTransactionRequestContract;

class DeclineDepositTransactionRequest extends BaseFormRequest implements DeclineDepositTransactionRequestContract
{
    public function rules(): array
    {
        return [
            'note' => ['nullable']
        ];
    }
}
