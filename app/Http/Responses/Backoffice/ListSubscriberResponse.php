<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListSubscriberResponseContract;
use App\Http\Resources\Backoffice\SubscriberResource;

class ListSubscriberResponse extends BaseResponse implements ListSubscriberResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(SubscriberResource::pagination($this->resource), $this->status, $this->headers);
    }
}
