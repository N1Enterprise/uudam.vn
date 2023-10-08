<?php

namespace App\Services;

class StoreFrontBannerService extends BaseService
{
    public $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function allAvailableBannerByType($type, $data = [])
    {
        $now = now();

        $banners = $this->bannerService->bannerRepository
            ->modelScopes(['active'])
            ->scopeQuery(function($q) use ($type, $now)  {
                $q->where('type', $type)
                    ->where(function($q) use ($now) {
                        $q->where('start_at', '<=', $now)
                            ->where('end_at', '>=', $now)
                            ->orWhereNull('end_at');
                    });
            })
            ->addSort('order', 'asc')
            ->addSort('id', 'asc')
            ->all(data_get($data, 'columns', ['*']));

        return $banners;
    }
}
