<?php

namespace App\Services;

use App\Models\User;
use App\Services\BaseService;
use App\Vendors\Localization\SystemCurrency;

class DashboardService extends BaseService
{
    public $defaultDate;
    public $userReportService;
    public $orderReportService;
    public $depositReportService;

    public function __construct(
        UserReportService $userReportService,
        OrderReportService $orderReportService,
        DepositReportService $depositReportService
    ) {
        $this->userReportService = $userReportService;
        $this->orderReportService = $orderReportService;
        $this->depositReportService = $depositReportService;

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

    public function getTotalNewOrders($data = [])
    {
        $data = $this->parseDataRequest($data);

        $result = $this->orderReportService->getTotalNewOrders($data);

        return $result;
    }

    public function getTotalDeposit($data = [])
    {
        $data = $this->parseDataRequest($data);

        $data = [
            'currency_code' => SystemCurrency::getDefaultCurrency()->code
        ];

        $result = $this->depositReportService->getTotalDeposit($data);

        return $result . ' ' . data_get($data, 'currency_code');
    }

    public function getTopUsers($data = [])
    {
        $data = $this->parseDataRequest($data);

        $result = $this->userReportService->getTopUsersGroup($data);

        $userIds = $result->pluck('user_id')->toArray();

        $users = User::whereIn('id', $userIds)
            ->select('id', 'name', 'currency_code')
            ->get()
            ->keyBy('id');

        $result = $result
            ->map(function ($item, $key) use ($users) {
                if (data_get($item, 'total_turnover', 0) == 0) {
                    return null;
                }

                $user = $users->get($item->user_id);

                data_set($item, 'rank', $key + 1);
                data_set($item, 'user_id', data_get($user, 'id'));
                data_set($item, 'username', data_get($user, 'username'));
                data_set($item, 'name', data_get($user, 'name'));
                data_set($item, 'email', data_get($user, 'email'));
                data_set($item, 'phone_number', data_get($user, 'phone_number'));

                return $item;
            })
            ->filter();

        return $result;
    }

    public function getTopOrders($data = [])
    {
        $data = $this->parseDataRequest($data);

        $result = $this->orderReportService->getTopOrdersGroupByUser($data);
    }

    protected function parseDataRequest($data)
    {
        data_set($data, 'from', data_get($data, 'date_range.0', data_get($this->defaultDate, 'from')));
        data_set($data, 'to', data_get($data, 'date_range.1', data_get($this->defaultDate, 'to')));

        return $data;
    }
}
