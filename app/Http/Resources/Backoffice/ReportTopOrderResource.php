<?php

namespace App\Http\Resources\Backoffice;

class ReportTopOrderResource extends BaseJsonResource
{
    public function toArray($request)
    {
        $resource = $this->resource;

        return [
            'rank' => data_get($resource, 'rank'),
        ];
    }
}
