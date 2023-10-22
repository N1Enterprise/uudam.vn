<?php

namespace App\Services;

use App\Repositories\Contracts\BannerRepositoryContract;
use App\Services\BaseService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            $attributes['desktop_image'] = $this->convertImage(data_get($attributes, 'desktop_image'));
            $attributes['mobile_image'] = $this->convertImage(data_get($attributes, 'mobile_image'));

            return $this->bannerRepository->create($attributes);
        });
    }

    protected function convertImage($image)
    {
        if ($imageUrl = data_get($image, 'path')) {
            return $imageUrl;
        } else if (data_get($image, 'file') && data_get($image, 'file') instanceof UploadedFile) {
            $imageFile = data_get($image, 'file');
            $filename  = $this->appearanceDisk()->putFile('/', $imageFile);
            $imageUrl = $this->appearanceDisk()->url($filename);

            return $imageUrl;
        }

        return null;
    }

    public function show($id, $columns = ['*'])
    {
        return $this->bannerRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $attributes['desktop_image'] = $this->convertImage(data_get($attributes, 'desktop_image'));
            $attributes['mobile_image'] = $this->convertImage(data_get($attributes, 'mobile_image'));

            return $this->bannerRepository->update($attributes, $id);
        });
    }

    public function delete($id)
    {
        return $this->bannerRepository->delete($id);
    }

    protected function appearanceDisk()
    {
        return Storage::disk('appearance');
    }
}
