<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserDetailRepositoryContract;
use App\Models\UserDetail;

class UserDetailRepository extends BaseRepository implements UserDetailRepositoryContract
{
    public function model()
    {
        return UserDetail::class;
    }
}
