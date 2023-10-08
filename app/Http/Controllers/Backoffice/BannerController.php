<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreBannerRequestContract;
use App\Contracts\Requests\Backoffice\UpdateBannerRequestContract;
use App\Contracts\Responses\Backoffice\DeleteBannerResponseContract;
use App\Contracts\Responses\Backoffice\StoreBannerResponseContract;
use App\Contracts\Responses\Backoffice\UpdateBannerResponseContract;
use App\Enum\BannerTypeEnum;
use App\Services\BannerService;

class BannerController extends BaseController
{
    public $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function index()
    {
        return view('backoffice.pages.banners.index');
    }

    public function create()
    {
        $bannerTypeEnumLabels = BannerTypeEnum::labels();

        return view('backoffice.pages.banners.create', compact('bannerTypeEnumLabels'));
    }

    public function edit($id)
    {
        $banner = $this->bannerService->show($id);
        $bannerTypeEnumLabels = BannerTypeEnum::labels();

        return view('backoffice.pages.banners.edit', compact('bannerTypeEnumLabels', 'banner'));
    }

    public function store(StoreBannerRequestContract $request)
    {
        $categoryGroup = $this->bannerService->create($request->validated());

        return $this->response(StoreBannerResponseContract::class, $categoryGroup);
    }

    public function update(UpdateBannerRequestContract $request, $id)
    {
        $categoryGroup = $this->bannerService->update($request->validated(), $id);

        return $this->response(UpdateBannerResponseContract::class, $categoryGroup);
    }

    public function destroy($id)
    {
        $status = $this->bannerService->delete($id);

        return $this->response(DeleteBannerResponseContract::class, ['status' => $status]);
    }
}
