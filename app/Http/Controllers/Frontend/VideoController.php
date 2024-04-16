<?php

namespace App\Http\Controllers\Frontend;

use App\Exceptions\ModelNotFoundException;
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
        $video = $this->videoService->findBySlugForGuest($slug, $request->all());

        if (empty($video)) throw new ModelNotFoundException();

        if ($video->slug != $slug) {
            return redirect()->route('fe.web.videos.index', ['slug' => $video->slug, 'id' => $video->id]);
        }

        return $this->view('frontend.pages.videos.index', compact('video'));
    }
}
