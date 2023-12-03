<?php

namespace App\Repositories;

use App\Models\UserActionLog;
use App\Repositories\Contracts\UserActionLogRepositoryContract;

class UserActionLogRepository extends BaseRepository implements UserActionLogRepositoryContract
{
    public function model()
    {
        return UserActionLog::class;
    }
}
