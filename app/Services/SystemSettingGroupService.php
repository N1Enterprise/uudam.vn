<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Repositories\Contracts\SystemSettingGroupRepositoryContract;

class SystemSettingGroupService extends BaseService
{
    public $systemSettingGroupRepository;

    public function __construct(SystemSettingGroupRepositoryContract $systemSettingGroupRepository)
    {
        $this->systemSettingGroupRepository = $systemSettingGroupRepository;
    }

    public function allWithSystemSettings()
    {
        return $this->systemSettingGroupRepository
            ->with('systemSettings')
            ->orderBy('order')
            ->all();
    }

    public function create($attributes = [])
    {
        $attributes['name'] = Str::lower(data_get($attributes, 'name'));

        return $this->systemSettingGroupRepository->create($attributes);
    }

    public function show($id)
    {
        return $this->systemSettingGroupRepository->findOrFail($id);
    }

    public function delete($id)
    {
        return DB::transaction(function() use ($id) {
            $group = $this->show($id);

            if (empty($group)) {
                return $group;
            }

            app(SystemSettingService::class)->deleteByGroup($group);

            return $group->delete();
        });
    }

    public function update($attributes, $id)
    {
        return $this->systemSettingGroupRepository->update($attributes, $id);
    }
}
