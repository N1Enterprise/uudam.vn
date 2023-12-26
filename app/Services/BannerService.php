<?php

namespace App\Services;

use App\Common\ImageHelper;
use App\Models\Banner;
use App\Repositories\Contracts\BannerRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Arr;
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

    public function searchAvailabelByGuest($data = [])
    {
        $now = now();

        $banners = $this->bannerRepository
            ->modelScopes(['active'])
            ->scopeQuery(function($q) use ($data, $now)  {
                $types = Arr::wrap(data_get($data, 'type', []));

                if (! empty($types)) {
                    $q->whereIn('type', $types);
                }

                $q->where(function($q) use ($now) {
                    $q->where('start_at', '<=', $now)
                        ->where('end_at', '>=', $now)
                        ->orWhereNull('end_at');
                });
            })
            ->addSort('order', 'asc')
            ->addSort('id', 'asc')
            ->all([
                'id', 
                'desktop_image',
                'mobile_image', 
                'cta_label', 
                'label', 
                'description', 
                'redirect_url'
            ]);

        return $banners;
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
