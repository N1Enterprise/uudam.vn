<?php

namespace App\Services;

use App\Exceptions\ExceptionCode;
use App\Exceptions\ModelNotFoundException;
use App\Repositories\Contracts\UserDetailRepositoryContract;

class UserDetailService extends BaseService
{
    public $userDetailRepository;

    public function __construct(UserDetailRepositoryContract $userDetailRepository)
    {
        $this->userDetailRepository = $userDetailRepository;
    }

    public function updateByUser($userId, $attributes = [])
    {
        $userDetail = $this->userDetailRepository->firstByField('user_id', $userId);

        if (! $userDetail) {
            throw new ModelNotFoundException('Invalid user.', ExceptionCode::INVALID_USER);
        }

        return $this->userDetailRepository->update($attributes, $userDetail->getKey());
    }
}
