<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreFaqRequestContract;
use App\Contracts\Requests\Backoffice\UpdateFaqRequestContract;
use App\Contracts\Responses\Backoffice\DeleteFaqResponseContract;
use App\Contracts\Responses\Backoffice\StoreFaqResponseContract;
use App\Contracts\Responses\Backoffice\UpdateFaqResponseContract;
use App\Services\FaqService;
use App\Services\FaqTopicService;

class FaqController extends BaseController
{
    public $faqService;
    public $faqTopicService;

    public function __construct(FaqService $faqService, FaqTopicService $faqTopicService)
    {
        $this->faqService = $faqService;
        $this->faqTopicService = $faqTopicService;
    }

    public function index()
    {
        return view('backoffice.pages.faqs.index');
    }

    public function create()
    {
        $faqTopics = $this->faqTopicService->allAvailable(['columns' => ['id', 'name']]);

        return view('backoffice.pages.faqs.create', compact('faqTopics'));
    }

    public function edit($id)
    {
        $faq = $this->faqService->show($id);
        $faqTopics = $this->faqTopicService->allAvailable(['columns' => ['id', 'name']]);

        return view('backoffice.pages.faqs.edit', compact('faq', 'faqTopics'));
    }

    public function store(StoreFaqRequestContract $request)
    {
        $faq = $this->faqService->create($request->validated());

        return $this->response(StoreFaqResponseContract::class, $faq);
    }

    public function update(UpdateFaqRequestContract $request, $id)
    {
        $faq = $this->faqService->update($request->validated(), $id);

        return $this->response(UpdateFaqResponseContract::class, $faq);
    }

    public function destroy($id)
    {
        $status = $this->faqService->delete($id);

        return $this->response(DeleteFaqResponseContract::class, ['status' => $status]);
    }
}
