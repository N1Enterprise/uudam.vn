<?php

namespace App\Services;

use App\Repositories\Contracts\FaqTopicRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class FaqTopicService extends BaseService
{
    public $faqTopicRepository;
    public $faqService;

    public function __construct(FaqTopicRepositoryContract $faqTopicRepository, FaqService $faqService)
    {
        $this->faqTopicRepository = $faqTopicRepository;
        $this->faqService = $faqService;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->faqTopicRepository
            ->with(['faqs'])
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function allAvailable($data = [])
    {
        return $this->faqTopicRepository->modelScopes(['active'])
            ->with(data_get($data, 'with', []))
            ->all(data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return $this->faqTopicRepository->create($attributes);
    }

    public function show($id, $columns = ['*'])
    {
        return $this->faqTopicRepository->findOrFail($id, $columns);
    }

    public function update($attributes = [], $id)
    {
        return $this->faqTopicRepository->update($attributes, $id);
    }

    public function delete($id)
    {
        return DB::transaction(function() use ($id) {
            $status = $this->faqTopicRepository->delete($id);

            $this->faqService->faqRepository
                ->getQuery()
                ->where('faq_topic_id', '=', $id)
                ->update(['faq_topic_id' => null]);

            return $status;
        });
    }
}
