<?php

namespace App\Services;

use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserReportService extends BaseService
{
    public function getTotalNewUsers($data = [])
    {
        $result = DB::table('users')
            ->where(function($q) use ($data) {
                if (data_get($data, 'from') && data_get($data, 'to')) {
                    $from = Carbon::parse(data_get($data, 'from'))->toISOString();
                    $to   = Carbon::parse(data_get($data, 'to'))->toISOString();

                    $q->whereBetween('created_at', [$from, $to]);
                }

                $q->where(function($q) {
                    $q->where('is_test_user', 0);
                });
            })
            ->count();

        return $result;
    }

    public function getTopUsersGroup($data = [])
    {
        $result = DB::table('orders')
            ->leftJoin('users', 'users.id', '=', 'orders.user_id')
            ->select('orders.user_id as user_id')
            ->selectRaw('SUM(orders.grand_total) as total_turnover')
            ->where(function($q) {
                $q->where('users.is_test_user', 0);
            })
            ->where(function ($q) use ($data) {
                if (data_get($data, 'from') && data_get($data, 'to')) {
                    $from = Carbon::parse(data_get($data, 'from'))->toISOString();
                    $to   = Carbon::parse(data_get($data, 'to'))->toISOString();

                    $q->whereBetween('orders.created_at', [$from, $to]);
                }

                if ($currencyCode = data_get($data, 'currency_code')) {
                    $q->where('orders.currency_code', '=', $currencyCode);
                }
            })
            ->groupBy('orders.user_id', 'orders.currency_code')
            ->orderByDesc('total_turnover')
            ->limit(20)
            ->get();

        return $result;
    }
}
