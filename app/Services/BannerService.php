<?php

namespace App\Services;

use App\Common\ImageHelper;
use App\Models\Banner;
use App\Repositories\Contracts\BannerRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class BannerService extends BaseService
{
    public $bannerRepository;

    public function __construct(BannerRepositoryContract $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->bannerRepository
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->bannerRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $imageHelper = ImageHelper::make('appearance')->hasOptimization();

            $attributes['desktop_image'] = $imageHelper
                ->setConfigKey([Banner::class, 'desktop_image'])
                ->uploadImage(data_get($attributes, 'desktop_image'));

            $attributes['mobile_image']  = $imageHelper
                ->setConfigKey([Banner::class, 'mobile_image'])
                ->uploadImage(data_get($attributes, 'mobile_image'));

            return $this->bannerRepository->create($attributes);
        });
    }

    public function show($id, $columns = ['*'])
    {
        return $this->bannerRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $imageHelper = ImageHelper::make('appearance')->hasOptimization();

            $attributes['desktop_image'] = $imageHelper
                ->setConfigKey([Banner::class, 'desktop_image'])
                ->uploadImage(data_get($attributes, 'desktop_image'));

            $attributes['mobile_image']  = $imageHelper
                ->setConfigKey([Banner::class, 'mobile_image'])
                ->uploadImage(data_get($attributes, 'mobile_image'));

            return $this->bannerRepository->update($attributes, $id);
        });
    }

    public function delete($id)
    {
        return $this->bannerRepository->delete($id);
    }
}
