<?php

namespace App\Http\Controllers\Frontend;

use App\Common\RequestHelper;
use App\Enum\SystemSettingKeyEnum;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MaintenanceController extends BaseController
{
    public function index(Request $request)
    {
        $maintenanceStartDate = SystemSetting::from(SystemSettingKeyEnum::MAINTENANCE_START_DATE)->get();
        $maintenanceEndDate = SystemSetting::from(SystemSettingKeyEnum::MAINTENANCE_END_DATE)->get();

        $maintenanceStartDate = empty($maintenanceStartDate) ? Carbon::now() : Carbon::parse($maintenanceStartDate);
        $maintenanceEndDate = empty($maintenanceEndDate) ? Carbon::parse($maintenanceStartDate)->addDays(10) : Carbon::parse($maintenanceEndDate);

        $maintenanceAllowIPsAccess = SystemSetting::from(SystemSettingKeyEnum::MAINTENANCE_ALLOW_IPS_ACCESS)->get(null, []);
        $isMaintenanceAllowIp = in_array(RequestHelper::getClientIpAdress($request), $maintenanceAllowIPsAccess);

        return $this->view('frontend.pages.maintenance.index', compact('maintenanceStartDate', 'maintenanceEndDate', 'isMaintenanceAllowIp'));
    }
}
