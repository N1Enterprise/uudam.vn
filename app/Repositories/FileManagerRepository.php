<?php

namespace App\Repositories;

use App\Models\FileManager;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\FileManagerRepositoryContract;

class FileManagerRepository extends BaseRepository implements FileManagerRepositoryContract
{
    public function model()
    {
        return FileManager::class;
    }
}
