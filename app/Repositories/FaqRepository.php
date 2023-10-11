<?php

namespace App\Repositories;

use App\Models\Faq;
use App\Repositories\Contracts\FaqRepositoryContract;

class FaqRepository extends BaseRepository implements FaqRepositoryContract
{
    public function model()
    {
        return Faq::class;
    }
}
