<?php

namespace App\Services;

use App\Repositories\Contracts\VideoCategoryRepositoryContract;
use Illuminate\Support\Facades\DB;

class VideoCategoryService extends BaseService
{
    public $videoCategoryRepository;

    public function __construct(VideoCategoryRepositoryContract $videoCategoryRepository)
    {
        $this->videoCategoryRepository = $videoCategoryRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->videoCategoryRepository
            ->appendIdSort()
            ->whereColumnsLike($data['query'] ?? null, ['name', 'slug']);

        return $result->search([], null, ['*'], data_get($data, 'paginate', true));
    }

    public function allAvailable()
    {
        return $this->videoCategoryRepository->modelScopes(['active'])->get();
    }

    public function show($id)
    {
        return $this->videoCategoryRepository->findOrFail($id);
    }

    public function create($attributes = [])
    {
        return $this->videoCategoryRepository->create($attributes);
    }

    public function update($attributes = [], $id)
    {
        return $this->videoCategoryRepository->update($attributes, $id);
    }

    public function delete($id)
    {
        return DB::transaction(function() use ($id) {
            $status = $this->videoCategoryRepository->delete($id);

            return $status;
        });
    }
}
