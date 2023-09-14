<?php

namespace App\Repositories;

use App\Models\SystemSetting;
use App\Repositories\Contracts\SystemSettingRepositoryContract;

class SystemSettingRepository extends BaseRepository implements SystemSettingRepositoryContract
{
    public function model()
    {
        return SystemSetting::class;
    }
}
