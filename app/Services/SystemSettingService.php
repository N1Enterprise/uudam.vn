<?php

namespace App\Services;

use App\Enum\SystemSettingImportOptionEnum;
use App\Events\User\SystemSettingUpdated;
use App\Repositories\Contracts\SystemSettingRepositoryContract;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SystemSettingService extends BaseService
{
    public $systemSettingRepository;
    public $systemSettingGroupService;

    public function __construct(SystemSettingRepositoryContract $systemSettingRepository, SystemSettingGroupService $systemSettingGroupService)
    {
        $this->systemSettingRepository = $systemSettingRepository;
        $this->systemSettingGroupService = $systemSettingGroupService;
    }

    public function show($id)
    {
        return $this->systemSettingRepository->findOrFail($id);
    }

    public function getSystemSettingGroups()
    {
        return $this->systemSettingGroupService->allWithSystemSettings();
    }

    public function clearCache()
    {
        Artisan::all('cache:clear');
    }

    public function deleteByGroup($groupId)
    {
        return $this->systemSettingRepository->deleteWhere(['group_id', $groupId]);
    }

    public function create($attributes = [])
    {
        $attributes['key'] = Str::lower($attributes['key']);

        return $this->systemSettingRepository->create($attributes);
    }

    public function updateByKey($key, $value)
    {
        $systemSetting = $this->systemSettingRepository->firstWhere(['key' => $key]);

        if (! $systemSetting) {
            return null;
        }

        return $this->systemSettingRepository->update([
            'value' => $value,
        ], $systemSetting);
    }

    public function update($id, $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $setting = $this->systemSettingRepository->update($data, $id);

            if ($setting->wasChanged('value')) {
                SystemSettingUpdated::dispatch($setting);
            }

            return $setting;
        });
    }

    public function delete($id)
    {
        return $this->systemSettingRepository->delete($id);
    }

    public function import($data)
    {
        return DB::transaction(function () use ($data) {
            $option = data_get($data, 'option');
            $groups = data_get($data, 'setting');

            foreach ($groups as $groupName => $settings) {
                if (empty($settings)) {
                    continue;
                }

                $group = $this->systemSettingGroupService->systemSettingGroupRepository
                    ->firstOrCreate(['name' => $groupName]);

                foreach ($settings as $setting) {
                    $settingKey = data_get($setting, 'key');
                    $settingValueType = data_get($setting, 'value_type');

                    if (empty($settingKey) || empty($settingValueType)) {
                        continue;
                    }

                    $getSetting = $this->systemSettingRepository->where('key', $settingKey)->first();
                    data_set($setting, 'group_id', $group->getKey());

                    if (empty($getSetting)) {
                        $this->create($setting);
                    } elseif ($option === SystemSettingImportOptionEnum::OVERRIDE) {
                        $this->update($getSetting->getKey(), $setting);
                    }
                }
            }

            return true;
        });
    }

    public function updateGroup($id, $data)
    {
        $data['group_name'] = Str::lower($data['name']);

        return $this->systemSettingGroupService->update($data, $id);
    }
}
