<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListReportTopUserResponseContract;
use App\Http\Resources\Backoffice\ReportTopUserResource;

class ListReportTopUserResponse extends BaseResponse implements ListReportTopUserResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(ReportTopUserResource::pagination(data_get($this->resource, 'data')), $this->status, $this->headers);
    }
}
