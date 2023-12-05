<?php

namespace App\Http\Controllers\Backoffice\Api;

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
}
