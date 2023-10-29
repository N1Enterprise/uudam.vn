<?php

namespace App\Repositories;

use App\Models\Subscriber;
use App\Repositories\Contracts\SubscriberRepositoryContract;

class SubscriberRepository extends BaseRepository implements SubscriberRepositoryContract
{
    public function model()
    {
        return Subscriber::class;
    }
}
