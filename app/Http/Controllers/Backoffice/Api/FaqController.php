<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListFaqResponseContract;
use App\Services\FaqService;
use Illuminate\Http\Request;

class FaqController extends BaseApiController
{
    public $faqService;

    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }

    public function index(Request $request)
    {
        $faq = $this->faqService->searchByAdmin($request->all());

        return $this->response(ListFaqResponseContract::class, $faq);
    }
}
