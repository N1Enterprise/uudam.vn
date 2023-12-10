<?php

namespace App\Repositories;

use App\Models\OauthUser;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\OauthUserRepositoryContract;

class OauthUserRepository extends BaseRepository implements OauthUserRepositoryContract
{
    public function model()
    {
        return OauthUser::class;
    }
}
