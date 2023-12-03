<?php

namespace App\Services;

use App\Repositories\Contracts\UserActionLogRepositoryContract;
use App\Services\BaseService;

class UserActionLogService extends BaseService
{
    public $userActionLogRepository;

    public function __construct(UserActionLogRepositoryContract $userActionLogRepository)
    {
        $this->userActionLogRepository = $userActionLogRepository;
    }

    public function create($attributes = [])
    {
        return $this->userActionLogRepository->create($attributes);
    }

    public function searchByAdmin($data)
    {
        $where = array_filter([
            'user_id' => data_get($data, 'user_id'),
        ]);

        return $this->userActionLogRepository->with(['createdBy'])
            ->whereColumnsLike(data_get($data, 'query'), ['id', 'reason', 'createdBy.email'])
            ->search($where);
    }

    public function show($id)
    {
        return $this->userActionLogRepository->findOrFail($id);
    }
}
