<?php

namespace App\Services;

use App\Common\ImageHelper;
use App\Models\FileManager;
use App\Repositories\Contracts\FileManagerRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class FileManagerService extends BaseService
{
    public $fileManagerRepository;

    public function __construct(FileManagerRepositoryContract $fileManagerRepository)
    {
        $this->fileManagerRepository = $fileManagerRepository;
    }

    public function upload($file)
    {
        return DB::transaction(function() use ($file) {
            $image = ImageHelper::make('file_manager')
                ->hasOptimization()
                ->setConfigKey([FileManager::class, 'content_editor'])
                ->uploadImage(['file' => $file]);

            return $image;
        });
    }
}
