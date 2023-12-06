<?php

namespace App\Http\Resources\Backoffice;

class ReportTopUserResource extends BaseJsonResource
{
    public function toArray($request)
    {
        $resource = $this->resource;

        return [
            'rank' => data_get($resource, 'rank'),
            'id' => data_get($resource, 'user_id'),
            'username' => data_get($resource, 'username'),
            'name' => data_get($resource, 'name'),
            'email' => data_get($resource, 'email'),
            'phone_number' => data_get($resource, 'phone_number'),
            'actions' => [
                'edit' => route('bo.web.users.edit', data_get($resource, 'user_id'))
            ],
            'total_turnover' => format_price(data_get($resource, 'total_turnover')),
        ];
    }
}
