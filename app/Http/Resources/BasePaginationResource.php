<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BasePaginationResource extends ResourceCollection
{
    public $collects;

    public $meta;

    public function __construct($resource, $collects, $meta = [])
    {
        $this->collects = $collects;

        $this->meta = $meta;

        parent::__construct($resource);
    }

    public function toArray($request)
    {
        if ($this->resource instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            return [
                'current_page' => (int) $this->resource->currentPage(),
                'last_page' => (int) $this->resource->lastPage(),
                'per_page' => (int) $this->resource->perPage(),
                'total' => (int) $this->resource->total(),
                'data' => $this->collects::collection($this->resource->items()),
                $this->mergeWhen(! empty($this->meta), ['meta' => $this->meta]),
            ];
        } else if ($this->resource instanceof \Illuminate\Pagination\Paginator){
            return [
                'has_more' => $this->resource->hasMorePages(),
                'current_page' => (int) $this->resource->currentPage(),
                'per_page' => (int) $this->resource->perPage(),
                'data' => $this->collects::collection($this->resource->items()),
                $this->mergeWhen(! empty($this->meta), ['meta' => $this->meta]),
            ];
        }

        return [
            'data' => $this->collects::collection($this->resource),
            $this->mergeWhen(! empty($this->meta), ['meta' => $this->meta]),
        ];
    }
}
