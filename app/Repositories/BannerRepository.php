<?php

namespace App\Repositories;

use App\Models\Banner;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\BannerRepositoryContract;

class BannerRepository extends BaseRepository implements BannerRepositoryContract
{
    public function model()
    {
        return Banner::class;
    }
}
