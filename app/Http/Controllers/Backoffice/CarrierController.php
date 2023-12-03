<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreCarrierRequestContract;
use App\Contracts\Requests\Backoffice\UpdateCarrierRequestContract;
use App\Contracts\Responses\Backoffice\StoreCarrierResponseContract;
use App\Contracts\Responses\Backoffice\UpdateCarrierResponseContract;
use App\Services\CarrierService;

class CarrierController extends BaseController
{
    public $carrierService;

    public function __construct(CarrierService $carrierService)
    {
        $this->carrierService = $carrierService;
    }

    public function index()
    {
        return view('backoffice.pages.carriers.index');
    }

    public function create()
    {
        return view('backoffice.pages.carriers.create');
    }

    public function edit($id)
    {
        $carrier = $this->carrierService->show($id);

        return view('backoffice.pages.carriers.edit', compact('carrier'));
    }

    public function store(StoreCarrierRequestContract $request)
    {
        $carrier = $this->carrierService->create($request->validated());

        return $this->response(StoreCarrierResponseContract::class, $carrier);
    }

    public function update(UpdateCarrierRequestContract $request, $id)
    {
        $carrier = $this->carrierService->update($request->validated(), $id);

        return $this->response(UpdateCarrierResponseContract::class, $carrier);
    }
}
