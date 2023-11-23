<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StorePageRequestContract;
use App\Contracts\Requests\Backoffice\UpdatePageRequestContract;
use App\Contracts\Responses\Backoffice\DeletePageResponseContract;
use App\Contracts\Responses\Backoffice\StorePageResponseContract;
use App\Contracts\Responses\Backoffice\UpdatePageResponseContract;
use App\Enum\PageDisplayInEnum;
use App\Services\PageService;

class PageController extends BaseController
{
    public $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function index()
    {
        return view('backoffice.pages.pages.index');
    }

    public function create()
    {
        $pageDisplayInEnumLabels = PageDisplayInEnum::labels();

        return view('backoffice.pages.pages.create', compact('pageDisplayInEnumLabels'));
    }

    public function edit($id)
    {
        $page = $this->pageService->show($id);
        $pageDisplayInEnumLabels = PageDisplayInEnum::labels();

        return view('backoffice.pages.pages.edit', compact('page', 'pageDisplayInEnumLabels'));
    }

    public function store(StorePageRequestContract $request)
    {
        $page = $this->pageService->create($request->validated());

        return $this->response(StorePageResponseContract::class, $page);
    }

    public function update(UpdatePageRequestContract $request, $id)
    {
        $page = $this->pageService->update($request->validated(), $id);

        return $this->response(UpdatePageResponseContract::class, $page);
    }

    public function destroy($id)
    {
        $status = $this->pageService->delete($id);

        return $this->response(DeletePageResponseContract::class, ['status' => $status]);
    }
}
