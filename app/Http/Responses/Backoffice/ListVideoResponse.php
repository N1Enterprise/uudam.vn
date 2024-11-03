<?php

namespace App\Http\Responses\Backoffice;

use Illuminate\Http\JsonResponse;
use App\Contracts\Responses\Backoffice\ListVideoResponseContract;
use App\Http\Resources\Backoffice\VideoResource;

class ListVideoResponse extends BaseResponse implements ListVideoResponseContract
{
    public function toResponse($request)
    {
        return new JsonResponse(VideoResource::pagination($this->resource), $this->status, $this->headers);
    }
}
