<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Requests\Backoffice\ImportSystemSettingRequestContract;
use App\Contracts\Requests\Backoffice\StoreSystemSettingGroupRequestContract;
use App\Contracts\Requests\Backoffice\StoreSystemSettingKeyRequestContract;
use App\Contracts\Requests\Backoffice\UpdateSystemSettingGroupRequestContract;
use App\Contracts\Requests\Backoffice\UpdateSystemSettingKeyRequestContract;
use App\Contracts\Responses\Backoffice\ClearCacheSystemSettingResponseContract;
use App\Contracts\Responses\Backoffice\DeleteSystemSettingGroupResponseContract;
use App\Contracts\Responses\Backoffice\DeleteSystemSettingKeyResponseContract;
use App\Contracts\Responses\Backoffice\ImportSystemSettingResponseContract;
use App\Contracts\Responses\Backoffice\StoreSystemSettingGroupResponseContract;
use App\Contracts\Responses\Backoffice\StoreSystemSettingKeyResponseContract;
use App\Contracts\Responses\Backoffice\UpdateSystemSettingGroupResponseContract;
use App\Services\SystemSettingGroupService;
use App\Services\SystemSettingService;
use Illuminate\Http\Request;

class SystemSettingController extends BaseApiController
{
    public $systemSettingService;
    public $systemSettingGroupService;

    public function __construct(SystemSettingService $systemSettingService, SystemSettingGroupService $systemSettingGroupService)
    {
        $this->systemSettingService = $systemSettingService;
        $this->systemSettingGroupService = $systemSettingGroupService;
    }

    public function clearCache(Request $request)
    {
        $this->systemSettingService->clearCache();

        return $this->response(ClearCacheSystemSettingResponseContract::class);
    }

    public function createGroup(StoreSystemSettingGroupRequestContract $request)
    {
        $group = $this->systemSettingGroupService->create($request->validated());

        return $this->response(StoreSystemSettingGroupResponseContract::class, $group);
    }

    public function deleteGroup(Request $request, $id)
    {
        $this->systemSettingGroupService->delete($id);

        return $this->response(DeleteSystemSettingGroupResponseContract::class);
    }

    public function createKey(StoreSystemSettingKeyRequestContract $request)
    {
        $settingKey = $this->systemSettingService->create($request->validated());

        return $this->response(StoreSystemSettingKeyResponseContract::class, $settingKey);
    }

    public function updateSettingKey(UpdateSystemSettingKeyRequestContract $request)
    {
        $data = $request->validated();

        $settingKey = $this->systemSettingService->updateByKey(data_get($data, 'key'), data_get($data, 'value'));

        return $this->response(StoreSystemSettingKeyResponseContract::class, $settingKey);
    }

    public function deleteSettingKey(Request $request, $id)
    {
        $this->systemSettingService->delete($id);

        return $this->response(DeleteSystemSettingKeyResponseContract::class, ['tab' => $request->tab]);
    }

    public function import(ImportSystemSettingRequestContract $request)
    {
        $attributes = $request->validated();
        $attributes = array_merge($attributes, [
            'setting' => json_decode(data_get($attributes, 'setting', '{}'), true)
        ]);

        $settings = $this->systemSettingService->import($attributes);

        return $this->response(ImportSystemSettingResponseContract::class, $settings);
    }

    public function updateGroup($id, UpdateSystemSettingGroupRequestContract $request)
    {
        $data = $request->validated();
        $group = $this->systemSettingService->updateGroup($id, [
            data_get($data, 'name') => data_get($data, 'value')
        ]);

        return $this->response(UpdateSystemSettingGroupResponseContract::class, $group);
    }
}
