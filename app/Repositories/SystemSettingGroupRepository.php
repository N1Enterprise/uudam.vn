<?php

namespace App\Repositories;

use App\Models\SystemSettingGroup;
use App\Repositories\Contracts\SystemSettingGroupRepositoryContract;

class SystemSettingGroupRepository extends BaseRepository implements SystemSettingGroupRepositoryContract
{
    public function model()
    {
        return SystemSettingGroup::class;
    }
}
