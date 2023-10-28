<?php

namespace App\Services;

use App\Repositories\Contracts\PostRepositoryContract;
use App\Services\BaseService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class PostService extends BaseService
{
    public $postRepository;

    public function __construct(PostRepositoryContract $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->postRepository
            ->with(['postCategory', 'createdBy', 'updatedBy'])
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->postRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $attributes['image'] = $this->convertImage(data_get($attributes, 'image'));

            return $this->postRepository->create($attributes);
        });
    }

    public function getListFeatured($data = [])
    {
        return $this->postRepository
            ->modelScopes(['featured', 'active'])
            ->addSort('order', 'desc')
            ->all(data_get($data, 'columns', ['*']));
    }

    public function show($id, $columns = ['*'])
    {
        return $this->postRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $attributes['image'] = $this->convertImage(data_get($attributes, 'image'));

            return $this->postRepository->update($attributes, $id);
        });
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

    public function delete($id)
    {
        return $this->postRepository->delete($id);
    }

    protected function utilityDisk()
    {
        return Storage::disk('utility');
    }

    public function getAvailableBySuggested($suggested, $data = [])
    {
        return $this->postRepository
            ->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->scopeQuery(function($q) use ($suggested) {
                $q->whereIn('id', Arr::wrap($suggested));
            })
            ->all(data_get($data, 'columns'));
    }

    public function findBySlug($slug, $data = [])
    {
        return $this->postRepository
            ->modelScopes(['active'])
            ->firstWhere(['slug' => $slug], data_get($data, 'columns', ['*']));
    }
}
