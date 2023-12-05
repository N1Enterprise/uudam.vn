<?php

namespace App\Services;

use App\Services\BaseService;

class DashboardService extends BaseService
{
    public $defaultDate;
    public $userReportService;

    public function __construct(UserReportService $userReportService)
    {
        $this->userReportService = $userReportService;

        $this->defaultDate = [
            'from' => convert_datetime_to_client_time(now()->utcOffset(getUtcOffset(true))->startOfDay(), true)->format('Y-m-d H:i:s'),
            'to'   => convert_datetime_to_client_time(now()->utcOffset(getUtcOffset(true))->endOfDay(), true)->format('Y-m-d H:i:s'),
        ];
    }

    public function getTotalNewUsers($data = [])
    {
        $data = $this->parseDataRequest($data);

        $result = $this->userReportService->getTotalNewUsers($data);

        return $result;
    }

    protected function parseDataRequest($data)
    {
        data_set($data, 'from', data_get($data, 'date_range.0', data_get($this->defaultDate, 'from')));
        data_set($data, 'to', data_get($data, 'date_range.1', data_get($this->defaultDate, 'to')));

        return $data;
    }
}
