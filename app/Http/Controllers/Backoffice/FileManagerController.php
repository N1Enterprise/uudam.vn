<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\UploadFileManagerRequestContract;
use App\Services\FileManagerService;

class FileManagerController extends BaseController
{
    public $fileManagerService;

    public function __construct(FileManagerService $fileManagerService)
    {
        $this->fileManagerService = $fileManagerService;
    }

    public function upload(UploadFileManagerRequestContract $request)
    {
        $fileManager = $this->fileManagerService->upload($request->file);

        return response()->json(['path' => $fileManager]);
    }
}
