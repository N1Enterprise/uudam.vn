<?php

namespace App\Services;

use App\Enum\FileManagerTypeEnum;
use App\Exceptions\BusinessLogicException;
use App\Repositories\Contracts\FileManagerRepositoryContract;
use App\Services\BaseService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileManagerService extends BaseService
{
    public $fileManagerRepository;

    public function __construct(FileManagerRepositoryContract $fileManagerRepository)
    {
        $this->fileManagerRepository = $fileManagerRepository;
    }

    public function upload($file, $diskName)
    {
        return DB::transaction(function() use ($file, $diskName) {
            if ($file instanceof UploadedFile) {
                $imageAnalysis = $this->analysisFile($file);
                $name = $imageAnalysis->getName();
                $ext  = $imageAnalysis->getExtension();
                $size = $imageAnalysis->getSize();
                $path = $imageAnalysis->getPath(Str::uuid());
                $disk = Storage::disk($diskName);

                $filename = $disk->putFile($path, $file);

                $fileResource = [
                    'name' => $name,
                    'ext'  => $ext,
                    'path' => $disk->url($filename),
                    'size' => $size,
                    'disk' => $diskName,
                    'type' => $this->getTypeByExtMapper($ext),
                ];

                return $this->create($fileResource);
            }
        });
    }

    public function create($attributes)
    {
        return $this->fileManagerRepository->create($attributes);
    }

    public function analysisFile($file)
    {
        return new class($file)
        {
            private $file;

            public function __construct($file)
            {
                $this->file = $file;
            }

            public function getName()
            {
                return Str::slug(pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME));
            }

            public function getExtension()
            {
                return $this->file->getClientOriginalExtension();
            }

            public function getSize()
            {
                return $this->file->getSize();
            }

            public function getPath($prefix = '')
            {
                return $prefix. '-' . $this->getName() . '.' . $this->getExtension();
            }
        };
    }

    protected function getTypeByExtMapper($ext)
    {
        $extMappers = [
            'jpg'  => FileManagerTypeEnum::IMAGE,
            'png'  => FileManagerTypeEnum::IMAGE,
            'jpeg' => FileManagerTypeEnum::IMAGE,
            'tiff' => FileManagerTypeEnum::IMAGE,
        ];

        if (empty($extMappers[ strtolower($ext) ])) {
            throw new BusinessLogicException('Dont support this extension: '.$ext);
        }

        return $extMappers[ strtolower($ext) ];
    }
}
