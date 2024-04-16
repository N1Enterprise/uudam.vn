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

    public function searchForGuest($data = [])
    {
        $where = [];

        $paginate = data_get($data, 'paginate', true);

        $result = $this->videoRepository
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

    public function findByGuest($field, $value, $data = [])
    {
        return $this->videoRepository
            ->modelScopes(['active', 'feDisplay'])
            ->firstWhere([$field => $value], data_get($data, 'columns', ['*']));
    }

    public function findBySlugForGuest($slug, $data = [])
    {
        $id = data_get($data, 'id');

        return $this->videoRepository
            ->modelScopes(['active', 'feDisplay'])
            ->selectColumns(data_get($data, 'columns', ['*']))
            ->scopeQuery(function($q) use ($slug, $id) {
                $q->where('slug', $slug)
                    ->orWhere('id', $id);
            })
            ->first();
    }
}
