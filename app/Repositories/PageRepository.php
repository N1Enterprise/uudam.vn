<?php

namespace App\Repositories;

use App\Models\Page;
use App\Repositories\Contracts\PageRepositoryContract;

class PageRepository extends BaseRepository implements PageRepositoryContract
{
    public function model()
    {
        return Page::class;
    }
}
