<?php

namespace App\Services;

use App\Repositories\Contracts\SubscriberRepositoryContract;
use App\Services\BaseService;

class SubscriberService extends BaseService
{
    public $subscriberRepository;

    public function __construct(SubscriberRepositoryContract $subscriberRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->subscriberRepository
            ->whereColumnsLike($data['query'] ?? null, ['email', 'type'])
            ->search([]);

        return $result;
    }

    public function show($id)
    {
        return $this->subscriberRepository->findOrFail($id);
    }

    public function findByEmail($email, $data = [])
    {
        return $this->subscriberRepository
            ->firstWhere(['email' => $email],  data_get($data, 'columns', ['*']));
    }

    public function create($attributes = [])
    {
        return $this->subscriberRepository->create($attributes);
    }

    public function subscribe($attributes = [])
    {
        $email = data_get($attributes, 'email');

        $subscriber = $this->findByEmail($email);

        if ($subscriber) {
            return $subscriber;
        }

        return $this->create($attributes);
    }
}
