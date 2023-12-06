<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListReportTopOrderResponseContract;
use App\Http\Resources\Backoffice\ReportTopOrderResource;

class ListReportTopOrderResponse extends BaseResponse implements ListReportTopOrderResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(ReportTopOrderResource::pagination(data_get($this->resource, 'data')), $this->status, $this->headers);
    }
}
