<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListReportTopOrderResponseContract;
use App\Contracts\Responses\Backoffice\ListReportTopUserResponseContract;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends BaseApiController
{
    public $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function getTotalNewUsers(Request $request)
    {
        $result = $this->dashboardService->getTotalNewUsers($request->all());

        return response()->json(['total_count' => $result]);
    }

    public function getTotalNewOrders(Request $request)
    {
        $result = $this->dashboardService->getTotalNewOrders($request->all());

        return response()->json(['total_count' => $result]);
    }

    public function getTotalDeposit(Request $request)
    {
        $result = $this->dashboardService->getTotalDeposit($request->all());

        return response()->json(['total_count' => $result]);
    }

    public function getTopUsers(Request $request)
    {
        $result = $this->dashboardService->getTopUsers($request->all());

        return $this->response(ListReportTopUserResponseContract::class, ['data' => $result]);
    }

    public function getTopOrders(Request $request)
    {
        $result = $this->dashboardService->getTopOrders($request->all());

        return $this->response(ListReportTopOrderResponseContract::class, ['data' => $result]);
    }
}
