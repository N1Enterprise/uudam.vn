<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreHomePageDisplayOrderRequestContract;
use App\Contracts\Requests\Backoffice\UpdateHomePageDisplayOrderRequestContract;
use App\Contracts\Responses\Backoffice\DeleteHomePageDisplayOrderResponseContract;
use App\Contracts\Responses\Backoffice\StoreHomePageDisplayOrderResponseContract;
use App\Contracts\Responses\Backoffice\UpdateHomePageDisplayOrderResponseContract;
use App\Services\HomePageDisplayOrderService;
use Illuminate\Http\Request;

class HomePageDisplayOrderController extends BaseController
{
    public $homePageDisplayOrderService;

    public function __construct(HomePageDisplayOrderService $homePageDisplayOrderService)
    {
        $this->homePageDisplayOrderService = $homePageDisplayOrderService;
    }

    public function index()
    {
        return view('backoffice.pages.home-page-display-orders.index');
    }

    public function create(Request $request)
    {
        return view('backoffice.pages.home-page-display-orders.create');
    }

    public function edit($id)
    {
        $homePageDisplayOrder = $this->homePageDisplayOrderService->show($id);
        
        return view('backoffice.pages.home-page-display-orders.edit', compact('homePageDisplayOrder'));
    }

    public function store(StoreHomePageDisplayOrderRequestContract $request)
    {
        $homePageDisplayOrder = $this->homePageDisplayOrderService->create($request->validated());

        return $this->response(StoreHomePageDisplayOrderResponseContract::class, $homePageDisplayOrder);
    }

    public function update(UpdateHomePageDisplayOrderRequestContract $request, $id)
    {
        $homePageDisplayOrder = $this->homePageDisplayOrderService->update($request->validated(), $id);

        return $this->response(UpdateHomePageDisplayOrderResponseContract::class, $homePageDisplayOrder);
    }

    public function destroy($id)
    {
        $status = $this->homePageDisplayOrderService->delete($id);

        return $this->response(DeleteHomePageDisplayOrderResponseContract::class, ['status' => $status]);
    }
}
