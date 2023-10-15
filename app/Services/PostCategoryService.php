<?php

namespace App\Services;

use App\Enum\ActivationStatusEnum;
use App\Repositories\Contracts\PostCategoryRepositoryContract;
use App\Services\BaseService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostCategoryService extends BaseService
{
    public $postCategoryRepository;

    public function __construct(PostCategoryRepositoryContract $postCategoryRepository)
    {
        $this->postCategoryRepository = $postCategoryRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->postCategoryRepository
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        if (data_get($data, 'with.posts')) {
            $data['with']['posts'] = ['posts' => function($q) {
                $q->where('status', ActivationStatusEnum::ACTIVE);
            }];
        }

        return $this->postCategoryRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $attributes['image'] = $this->convertImage(data_get($attributes, 'image'));

            return $this->postCategoryRepository->create($attributes);
        });
    }

    public function show($id, $columns = ['*'])
    {
        return $this->postCategoryRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $attributes['image'] = $this->convertImage(data_get($attributes, 'image'));

            return $this->postCategoryRepository->update($attributes, $id);
        });
    }

    public function delete($id)
    {
        return $this->postCategoryRepository->delete($id);
    }

    protected function convertImage($image)
    {
        if ($imageUrl = data_get($image, 'path')) {
            return $imageUrl;
        } else if (data_get($image, 'file') && data_get($image, 'file') instanceof UploadedFile) {
            $imageFile = data_get($image, 'file');
            $filename  = $this->utilityDisk()->putFile('/', $imageFile);
            $imageUrl = $this->utilityDisk()->url($filename);

            return $imageUrl;
        }

        return null;
    }

    protected function utilityDisk()
    {
        return Storage::disk('utility');
    }
}
