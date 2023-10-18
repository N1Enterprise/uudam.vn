<?php

namespace App\Services;

use App\Repositories\Contracts\PageRepositoryContract;
use App\Services\BaseService;

class PageService extends BaseService
{
    public $pageRepository;

    public function __construct(PageRepositoryContract $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->pageRepository
            ->with(['createdBy', 'updatedBy'])
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->pageRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->addSort('order', 'desc')
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return $this->pageRepository->create($attributes);
    }

    public function show($id, $columns = ['*'])
    {
        return $this->pageRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return $this->pageRepository->update($attributes, $id);
    }

    public function delete($id)
    {
        return $this->pageRepository->delete($id);
    }
}
