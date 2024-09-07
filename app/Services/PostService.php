<?php

namespace App\Services;

use App\Common\ImageHelper;
use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

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

        $paginate = data_get($data, 'paginate', true);

        $orderBy = data_get($data, 'order_by', 'order');
        $sortBy = 'desc';

        $result = $this->postRepository
            ->with(['postCategory', 'createdBy'])
            ->modelScopes(['active', 'feDisplay'])
            ->scopeQuery(function($q) use ($data) {
                $filterIds = data_get($data, 'filter_ids', []);

                if (! empty($filterIds)) {
                    $q->whereIn('id', $filterIds);
                }

                $postCategoryId = data_get($data, 'post_category_id');

                if (! empty($postCategoryId)) {
                    $q->where('post_category_id', $postCategoryId);
                }
            })
            ->addSort($orderBy, $sortBy);

        return $paginate
            ? $result->search($where, null, ['*'], true, data_get($data, 'paging', 'paginate'))
            : $result->all();
    }

    public function getAvailableByIds($ids = [], $data = [])
    {
        return $this->postRepository
            ->modelScopes(array_merge(['active'], data_get($data, 'scopes', [])))
            ->with(data_get($data, 'with', []))
            ->orderBy('order')
            ->scopeQuery(function($q) use ($ids) {
                $q->whereIn('id', $ids);
            })
            ->all(data_get($data, 'columns', ['*']));
    }

    public function allAvailable($data = [])
    {
        return $this->postRepository
            ->modelScopes(array_merge(['active'], data_get($data, 'scopes', [])))
            ->with(data_get($data, 'with', []))
            ->orderBy('order')
            ->all(data_get($data, 'columns', ['*']));
    }

    public function syncProducts(Post $post, $products = [])
    {
        $post->linkedProducts()->sync($products);
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $attributes['image'] = ImageHelper::make('utility')
                ->hasOptimization()
                ->setConfigKey([Post::class, 'image'])
                ->uploadImage(data_get($attributes, 'image'));

            $post = $this->postRepository->create($attributes);

            $this->syncProducts($post, Arr::wrap(data_get($attributes, 'linked_products', [])));

            return $post;
        });
    }

    public function show($id, $columns = ['*'])
    {
        return $this->postRepository->with(['linkedProducts'])->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $attributes['image'] = ImageHelper::make('utility')
                ->hasOptimization()
                ->setConfigKey([Post::class, 'image'])
                ->uploadImage(data_get($attributes, 'image'));

            $post = $this->postRepository->update($attributes, $id);

            $this->syncProducts($post, Arr::wrap(data_get($attributes, 'linked_products', [])));

            return $post;
        });
    }

    public function delete($id)
    {
        return $this->postRepository->delete($id);
    }

    public function findBySlugForGuest($slug, $data = [])
    {
        $code = data_get($data, 'code');

        return $this->postRepository
            ->modelScopes(['active'])
            ->scopeQuery(function($q) use ($slug, $code) {
                $q->where('slug', $slug)
                    ->orWhere('code', $code);
            })
            ->first(data_get($data, 'columns', ['*']));
    }
}
