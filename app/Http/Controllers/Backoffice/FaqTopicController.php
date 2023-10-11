<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreFaqTopicRequestContract;
use App\Contracts\Requests\Backoffice\UpdateFaqTopicRequestContract;
use App\Contracts\Responses\Backoffice\DeleteFaqTopicResponseContract;
use App\Contracts\Responses\Backoffice\StoreFaqTopicResponseContract;
use App\Contracts\Responses\Backoffice\UpdateFaqTopicResponseContract;
use App\Services\FaqTopicService;

class FaqTopicController extends BaseController
{
    public $faqTopicService;

    public function __construct(FaqTopicService $faqTopicService)
    {
        $this->faqTopicService = $faqTopicService;
    }

    public function index()
    {
        return view('backoffice.pages.faq-topics.index');
    }

    public function create()
    {
        return view('backoffice.pages.faq-topics.create');
    }

    public function edit($id)
    {
        $faqTopic = $this->faqTopicService->show($id);

        return view('backoffice.pages.faq-topics.edit', compact('faqTopic'));
    }

    public function store(StoreFaqTopicRequestContract $request)
    {
        $faqTopic = $this->faqTopicService->create($request->validated());

        return $this->response(StoreFaqTopicResponseContract::class, $faqTopic);
    }

    public function update(UpdateFaqTopicRequestContract $request, $id)
    {
        $faqTopic = $this->faqTopicService->update($request->validated(), $id);

        return $this->response(UpdateFaqTopicResponseContract::class, $faqTopic);
    }

    public function destroy($id)
    {
        $status = $this->faqTopicService->delete($id);

        return $this->response(DeleteFaqTopicResponseContract::class, ['status' => $status]);
    }
}
