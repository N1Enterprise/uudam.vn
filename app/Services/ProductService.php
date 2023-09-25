<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryContract;
use App\Services\BaseService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            ->with(['createdBy', 'updatedBy'])
            ->whereColumnsLike($data['query'] ?? null, ['name'])
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
            $attributes['primary_image'] = $this->convertImage(data_get($attributes, 'primary_image'));
            $attributes['media']['image'] = $this->convertMediaImage(data_get($attributes, 'media.image', []));

            $product = $this->productRepository->create($attributes);

            $this->syncCategories($product, data_get($attributes, 'categories', []));

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

            $attributes['primary_image'] = $this->convertImage(data_get($attributes, 'primary_image'));
            $attributes['media']['image'] = $this->convertMediaImage(data_get($attributes, 'media.image', []));

            $product = $this->productRepository->update($attributes, $product->getKey());

            $this->syncCategories($product, data_get($attributes, 'categories', []));

            return $product;
        });
    }

    protected function syncCategories(Product $product, $categories = [])
    {
        return $product->categories()->sync($categories);
    }

    protected function convertImage($image)
    {
        if ($imageUrl = data_get($image, 'path')) {
            return $imageUrl;
        } else if (data_get($image, 'file') && data_get($image, 'file') instanceof UploadedFile) {
            $imageFile = data_get($image, 'file');
            $filename  = $this->catalogDisk()->putFile('/', $imageFile);
            $imageUrl = $this->catalogDisk()->url($filename);

            return $imageUrl;
        }

        return null;
    }

    protected function convertMediaImage($mediaImages = [])
    {
        $counter = 0;

        return array_map(function($image) use (&$counter) {
            return [
                'order' => $counter++,
                'path' => $this->convertImage($image),
            ];
        }, $mediaImages);
    }

    protected function catalogDisk()
    {
        return Storage::disk('catalog');
    }
}
