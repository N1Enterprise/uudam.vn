<?php

namespace App\Services;

use App\Common\ImageHelper;
use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
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

    public function searchForGuest($data = [])
    {
        $where = [];

        $result = $this->postRepository
            ->with(data_get($data, 'with', []))
            ->modelScopes(['active', 'feDisplay'])
            ->scopeQuery(function($q) use ($data) {
                $filterIds = data_get($data, 'filter_ids', []);

                if (! empty($filterIds)) {
                    $q->whereIn('id', $filterIds);
                }
            });

        return $result->search($where, null, ['*'], true, data_get($data, 'paging', 'paginate'));
    }

    public function allAvailable($data = [])
    {
        return $this->postRepository
            ->modelScopes(array_merge(['active'], data_get($data, 'scopes', [])))
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $attributes['image'] = ImageHelper::make('utility')
                ->hasOptimization()
                ->setConfigKey([Post::class, 'image'])
                ->uploadImage(data_get($attributes, 'image'));

            return $this->postRepository->create($attributes);
        });
    }

    public function show($id, $columns = ['*'])
    {
        return $this->postRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $attributes['image'] = ImageHelper::make('utility')
                ->hasOptimization()
                ->setConfigKey([Post::class, 'image'])
                ->uploadImage(data_get($attributes, 'image'));

            return $this->postRepository->update($attributes, $id);
        });
    }

    public function delete($id)
    {
        return $this->postRepository->delete($id);
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
