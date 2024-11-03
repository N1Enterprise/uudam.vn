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
            ->whereColumnsLike($data['query'] ?? null, ['name', 'slug', 'title'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->pageRepository
            ->modelScopes(array_merge(['active'], data_get($data, 'scopes')))
            ->with(data_get($data, 'with', []))
            ->addSort('order', 'asc')
            ->all(data_get($data, 'columns', ['*']));
    }

    public function searchForGuest($data = [])
    {
        $where = [];

        $paginate = data_get($data, 'paginate', true);

        $result = $this->pageRepository
            ->with(data_get($data, 'with', []))
            ->modelScopes(['active', 'feDisplay'])
            ->scopeQuery(function($q) use ($data) {
                $filterIds = data_get($data, 'filter_ids', []);

                if (! empty($filterIds)) {
                    $q->whereIn('id', $filterIds);
                }
            });

        return $paginate
            ? $result->search($where, null, ['*'], true, data_get($data, 'paging', 'paginate'))
            : $result->all();
    }

    public function listByUser($data = [])
    {
        return $this->pageRepository
            ->modelScopes(array_merge(['active', 'feDisplay'], data_get($data, 'scopes')))
            ->with(data_get($data, 'with', []))
            ->addSort('order', 'asc')
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

    public function findBySlugForGuest($slug, $data = [])
    {
        $id = data_get($data, 'id');

        return $this->pageRepository
            ->modelScopes(['active', 'feDisplay'])
            ->selectColumns(data_get($data, 'columns', ['*']))
            ->scopeQuery(function($q) use ($slug, $id) {
                $q->where('slug', $slug)
                    ->orWhere('id', $id);
            })
            ->first();
    }
}
