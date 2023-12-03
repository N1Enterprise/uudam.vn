<?php

namespace App\Http\Controllers\Frontend;

use App\Enum\SystemSettingKeyEnum;
use App\Models\SystemSetting;
use Carbon\Carbon;

class MaintenanceController extends BaseController
{
    public function index()
    {
        $maintenanceStartDate = SystemSetting::from(SystemSettingKeyEnum::MAINTENANCE_START_DATE)->get();
        $maintenanceEndDate = SystemSetting::from(SystemSettingKeyEnum::MAINTENANCE_END_DATE)->get();

        $maintenanceStartDate = empty($maintenanceStartDate) ? Carbon::now() : Carbon::parse($maintenanceStartDate);
        $maintenanceEndDate = empty($maintenanceEndDate) ? Carbon::parse($maintenanceStartDate)->addDays(10) : Carbon::parse($maintenanceEndDate);

        return $this->view('frontend.pages.maintenance.index', compact('maintenanceStartDate', 'maintenanceEndDate'));
    }
}
