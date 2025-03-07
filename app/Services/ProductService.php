<?php

namespace App\Services;

use App\Common\ImageHelper;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProductService extends BaseService
{
    public $productRepository;

    public function __construct(ProductRepositoryContract $productRepository)
    {
        $this->productRepository = $productRepository;

    }

    public function searchByAdmin($data = [])
    {
        $result = $this->productRepository
            ->with(['createdBy', 'updatedBy', 'categories'])
            ->whereColumnsLike($data['query'] ?? null, ['id', 'name', 'slug', 'code'])
            ->scopeQuery(function($q) use ($data) {
                $categories = Arr::wrap(data_get($data, 'categories', []));

                if (! empty($categories)) {
                    $q->whereRelation('categories', function($q) use ($categories) {
                        $q->whereIn('category_id', $categories);
                    });
                }

                if ($status = Arr::wrap(data_get($data, 'status'))) {
                    $q->whereIn('status', $status);
                }

                if ($type = Arr::wrap(data_get($data, 'type'))) {
                    $q->whereIn('type', $type);
                }
            })
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->productRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return DB::transaction(function() use ($attributes) {
            $attributes['primary_image'] = ImageHelper::make('catalog')
                ->hasOptimization()
                ->setConfigKey([Product::class, 'primary_image'])
                ->uploadImage(data_get($attributes, 'primary_image'));

            $attributes['media']['image'] = $this->convertMediaImage(data_get($attributes, 'media.image', []));

            $product = $this->productRepository->create($attributes);

            $this->syncCategories($product, data_get($attributes, 'categories', []));
            $this->syncPosts($product, data_get($attributes, 'linked_posts', []));

            return $product;
        });
    }

    public function show($id, $data = [])
    {
        return $this->productRepository
            ->with(data_get($data, 'with', []))
            ->findOrFail($id, data_get($data, 'columns', ['*']));
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function() use ($attributes, $id) {
            /** @var Product */
            $product = $this->show($id);

            $attributes['primary_image'] = ImageHelper::make('catalog')
                ->hasOptimization()
                ->setConfigKey([Product::class, 'primary_image'])
                ->uploadImage(data_get($attributes, 'primary_image'));

            $attributes['media']['image'] = $this->convertMediaImage(data_get($attributes, 'media.image', []));

            $product = $this->productRepository->update($attributes, $product->getKey());

            $this->syncCategories($product, data_get($attributes, 'categories', []));
            $this->syncPosts($product, data_get($attributes, 'linked_posts', []));

            return $product;
        });
    }

    protected function syncCategories(Product $product, $categories = [])
    {
        return $product->categories()->sync($categories);
    }

    public function syncPosts(Product $product, $posts = [])
    {
        $product->linkedPosts()->sync($posts);
    }

    protected function convertMediaImage($mediaImages = [])
    {
        $counter = 0;

        return array_map(function($image) use (&$counter) {
            return [
                'order' => $counter++,
                'path'  => ImageHelper::make('catalog')
                    ->hasOptimization()
                    ->setConfigKey([Product::class, 'primary_image'])
                    ->uploadImage($image),
            ];
        }, $mediaImages);
    }
}
