<?php

namespace App\Services;

use App\Enum\DepositStatusEnum;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DepositReportService extends BaseService
{
    public function getTotalDeposit($data = [])
    {
        return DB::table('deposit_transactions', 'dt')
            ->leftJoin('users', 'users.id', '=', 'dt.user_id')
            ->where(function($q) {
                $q->where('users.is_test_user', 0);
            })
            ->where('dt.status', '=', DepositStatusEnum::APPROVED)
            ->where(function ($q) use ($data) {
                if (data_get($data, 'from') && data_get($data, 'to')) {
                    $from = Carbon::parse(data_get($data, 'from'))->toISOString();
                    $to = Carbon::parse(data_get($data, 'to'))->toISOString();

                    $q->whereBetween('dt.updated_at', [$from, $to]);
                }
                if ($currencyCode = data_get($data, 'currency_code')) {
                    $q->where('dt.currency_code', '=', $currencyCode);
                }
            })
            ->sum('dt.amount');
    }
}
