<?php

namespace App\Repositories;

use App\Models\DepositTransaction;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\DepositTransactionRepositoryContract;

class DepositTransactionRepository extends BaseRepository implements DepositTransactionRepositoryContract
{
    public function model()
    {
        return DepositTransaction::class;
    }
}
