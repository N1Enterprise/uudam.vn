<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListDepositTransactionResponseContract;
use App\Http\Resources\Backoffice\DepositTransactionResource;

class ListDepositTransactionResponse extends BaseResponse implements ListDepositTransactionResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(DepositTransactionResource::pagination($this->resource), $this->status, $this->headers);
    }
}
