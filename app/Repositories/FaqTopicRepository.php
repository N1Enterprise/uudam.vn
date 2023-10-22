<?php

namespace App\Repositories;

use App\Models\FaqTopic;
use App\Repositories\Contracts\FaqTopicRepositoryContract;

class FaqTopicRepository extends BaseRepository implements FaqTopicRepositoryContract
{
    public function model()
    {
        return FaqTopic::class;
    }
}
