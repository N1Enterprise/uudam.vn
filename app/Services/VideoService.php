<?php

namespace App\Services;

use App\Common\ImageHelper;
use App\Models\Video;
use App\Repositories\Contracts\VideoRepositoryContract;
use Illuminate\Support\Facades\DB;

class VideoService extends BaseService
{
    public $videoRepository;

    public function __construct(VideoRepositoryContract $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->videoRepository
            ->with(['createdBy', 'updatedBy', 'category'])
            ->appendIdSort()
            ->whereColumnsLike($data['query'] ?? null, ['name', 'slug']);

        return $result->search([], null, ['*'], data_get($data, 'paginate', true));
    }

    public function allAvailable()
    {
        return $this->videoRepository->modelScopes(['active'])->get();
    }

    public function show($id)
    {
        return $this->videoRepository->findOrFail($id);
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $attributes['thumbnail'] = ImageHelper::make('video')
                ->hasOptimization()
                ->setConfigKey([Video::class, 'thumbnail'])
                ->uploadImage(data_get($attributes, 'thumbnail'));

            return $this->videoRepository->create($attributes);
        });
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $attributes['thumbnail'] = ImageHelper::make('catalog')
                ->hasOptimization()
                ->setConfigKey([Video::class, 'thumbnail'])
                ->uploadImage(data_get($attributes, 'thumbnail'));

            return $this->videoRepository->update($attributes, $id);
        });
    }

    public function delete($id)
    {
        return $this->videoRepository->delete($id);
    }
}
