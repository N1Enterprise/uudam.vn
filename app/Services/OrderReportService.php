<?php

namespace App\Services;

use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderReportService extends BaseService
{
    public function getTotalNewOrders($data = [])
    {
        $result = DB::table('orders')
            ->where(function($q) use ($data) {
                if (data_get($data, 'from') && data_get($data, 'to')) {
                    $from = Carbon::parse(data_get($data, 'from'))->toISOString();
                    $to   = Carbon::parse(data_get($data, 'to'))->toISOString();

                    $q->whereBetween('created_at', [$from, $to]);
                }
            })
            ->count();

        return $result;
    }

    public function getTopOrdersGroupByUser($data = [])
    {

    }
}
