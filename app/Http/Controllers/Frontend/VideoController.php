<?php

namespace App\Http\Controllers\Frontend;

use App\Services\VideoService;
use Illuminate\Http\Request;

class VideoController extends BaseController
{
    public $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    public function index(Request $request, $slug)
    {
        $video = $this->videoService->findByGuest('slug', $slug);

        return $this->view('frontend.pages.videos.index', compact('video'));
    }
}
