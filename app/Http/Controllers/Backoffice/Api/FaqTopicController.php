<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListFaqTopicResponseContract;
use App\Services\FaqTopicService;
use Illuminate\Http\Request;

class FaqTopicController extends BaseApiController
{
    public $faqTopicService;

    public function __construct(FaqTopicService $faqTopicService)
    {
        $this->faqTopicService = $faqTopicService;
    }

    public function index(Request $request)
    {
        $faqTopic = $this->faqTopicService->searchByAdmin($request->all());

        return $this->response(ListFaqTopicResponseContract::class, $faqTopic);
    }
}
