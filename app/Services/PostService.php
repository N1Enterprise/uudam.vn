<?php

namespace App\Services;

use App\Repositories\Contracts\PostRepositoryContract;
use App\Services\BaseService;

class PostService extends BaseService
{
    public $postService;

    public function __construct(PostRepositoryContract $postService)
    {
        $this->postService = $postService;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->postService
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->postService->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return $this->postService->create($attributes);
    }

    public function show($id, $columns = ['*'])
    {
        return $this->postService->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return $this->postService->update($attributes, $id);
    }

    public function delete($id)
    {
        return $this->postService->delete($id);
    }
}
