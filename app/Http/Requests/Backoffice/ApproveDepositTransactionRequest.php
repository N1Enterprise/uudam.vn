<?php

namespace App\Http\Requests\Backoffice;

use App\Contracts\Requests\Backoffice\ApproveDepositTransactionRequestContract;

class ApproveDepositTransactionRequest extends BaseFormRequest implements ApproveDepositTransactionRequestContract
{
    public function rules(): array
    {
        return [
            'note' => ['nullable']
        ];
    }
}
