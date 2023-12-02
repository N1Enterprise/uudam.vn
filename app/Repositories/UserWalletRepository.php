<?php

namespace App\Repositories;

use App\Models\UserWallet;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\UserWalletRepositoryContract;

class UserWalletRepository extends BaseRepository implements UserWalletRepositoryContract
{
    public function model()
    {
        return UserWallet::class;
    }
}
