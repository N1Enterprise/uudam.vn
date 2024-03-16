<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListVideoResponseContract;
use App\Services\VideoService;
use Illuminate\Http\Request;

class VideoController extends BaseApiController
{
    public $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    public function index(Request $request)
    {
        $videos = $this->videoService->searchByAdmin($request->all());

        return $this->response(ListVideoResponseContract::class, $videos);
    }
}
