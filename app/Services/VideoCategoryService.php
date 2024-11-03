<?php

namespace App\Services;

use App\Repositories\Contracts\VideoCategoryRepositoryContract;
use App\Repositories\Contracts\VideoRepositoryContract;
use Illuminate\Support\Facades\DB;

class VideoCategoryService extends BaseService
{
    public $videoCategoryRepository;
    public $videoRepository;

    public function __construct(VideoCategoryRepositoryContract $videoCategoryRepository, VideoRepositoryContract $videoRepository)
    {
        $this->videoCategoryRepository = $videoCategoryRepository;
        $this->videoRepository = $videoRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->videoCategoryRepository
            ->with(['createdBy', 'updatedBy'])
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

            $this->videoRepository->getNewModel()->query()
                ->where('video_category_id', $id)
                ->update(['video_category_id' => null]);

            return $status;
        });
    }

    public function searchByGuest($data = [])
    {
        $paginate = data_get($data, 'paginate', true);

        $builder = $this->videoCategoryRepository
            ->modelScopes(['active', 'feDisplay'])
            ->with(['videos'])
            ->scopeQuery(function($q) {
                $q->whereHas('videos', function($q) {
                    $q->where('status', 1)
                        ->where('display_on_frontend', 1)
                        ->orderBy('order', 'asc');
                });
            })
            ->orderBy('order', 'asc');

        return $paginate 
            ? $builder->search()
            : $builder->all();
    }
}
