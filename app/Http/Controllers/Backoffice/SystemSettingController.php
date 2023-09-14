<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\UpdateSystemSettingRequestContract;
use App\Contracts\Responses\Backoffice\UpdateSystemSettingResponseContract;
use App\Enum\SystemSettingImportOptionEnum;
use App\Enum\SystemSettingValueTypeEnum;
use App\Http\Controllers\Backoffice\BaseController;
use App\Services\SystemSettingService;
use Illuminate\Http\Request;

class SystemSettingController extends BaseController
{
    public $systemSettingService;

    public function __construct(SystemSettingService $systemSettingService)
    {
        $this->systemSettingService = $systemSettingService;
    }

    public function index(Request $request)
    {
        $groups = $this->systemSettingService->getSystemSettingGroups();
        $settingTypes = SystemSettingValueTypeEnum::labels();
        $importOption = SystemSettingImportOptionEnum::labels();
        $tab = $request->tab;

        return $this->view('backoffice.pages.system-settings.index', compact('groups', 'settingTypes', 'importOption', 'tab'));
    }

    public function edit($id)
    {
        $systemSetting = $this->systemSettingService->show($id);
        $groups = $this->systemSettingService->getSystemSettingGroups();

        return $this->view('backoffice.pages.system-settings.edit', compact('systemSetting', 'groups'));
    }

    public function update($id, UpdateSystemSettingRequestContract $request)
    {
        $data = $request->validated();
        $systemSetting = $this->systemSettingService->update($id, $data);

        return $this->response(UpdateSystemSettingResponseContract::class, $systemSetting);
    }
}
