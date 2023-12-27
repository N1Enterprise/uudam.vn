<?php

namespace App\Services;

use App\Common\ImageHelper;
use App\Enum\ActivationStatusEnum;
use App\Models\PostCategory;
use App\Repositories\Contracts\PostCategoryRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

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

    public function searchForGuest($data = [])
    {
        $where = [];

        $result = $this->postCategoryRepository
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
        if (data_get($data, 'with.posts')) {
            $data['with']['posts'] = ['posts' => function($q) {
                $q->where('status', ActivationStatusEnum::ACTIVE);
            }];
        }

        return $this->postCategoryRepository
            ->modelScopes(array_merge(['active'], data_get($data, 'scopes', [])))
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function getAvailableDisplayOnFE($data = [])
    {
        if (data_get($data, 'with.posts')) {
            $data['with']['posts'] = ['posts' => function($q) {
                $q->where('status', ActivationStatusEnum::ACTIVE)
                    ->where('display_on_frontend', ActivationStatusEnum::ACTIVE);
            }];
        }

        return $this->postCategoryRepository
            ->modelScopes(['active', 'feDisplay'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $attributes['image'] = ImageHelper::make('utility')
                ->hasOptimization()
                ->setConfigKey([PostCategory::class, 'image'])
                ->uploadImage(data_get($attributes, 'image'));

            return $this->postCategoryRepository->create($attributes);
        });
    }

    public function show($id, $data = [])
    {
        return $this->postCategoryRepository
            ->modelScopes(data_get($data, 'scopes', []))
            ->findOrFail($id, data_get($data, 'columns', ['*']));
    }

    public function findByUser($slug, $data = [])
    {
        return $this->postCategoryRepository
            ->with(['posts'])
            ->modelScopes(['active', 'feDisplay'])
            ->firstWhere(['slug' => $slug], data_get($data, 'columns', ['*']));
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $attributes['image'] = ImageHelper::make('utility')
                ->hasOptimization()
                ->setConfigKey([PostCategory::class, 'image'])
                ->uploadImage(data_get($attributes, 'image'));

            return $this->postCategoryRepository->update($attributes, $id);
        });
    }

    public function delete($id)
    {
        return $this->postCategoryRepository->delete($id);
    }
}
