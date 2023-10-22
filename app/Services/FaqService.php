<?php

namespace App\Services;

use App\Repositories\Contracts\FaqRepositoryContract;
use App\Services\BaseService;

class FaqService extends BaseService
{
    public $faqRepository;

    public function __construct(FaqRepositoryContract $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->faqRepository
            ->with(['faqTopic'])
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->faqRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return $this->faqRepository->create($attributes);
    }

    public function show($id, $columns = ['*'])
    {
        return $this->faqRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return $this->faqRepository->update($attributes, $id);
    }

    public function delete($id)
    {
        return $this->faqRepository->delete($id);
    }
}
