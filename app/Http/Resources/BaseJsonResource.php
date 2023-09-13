<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

abstract class BaseJsonResource extends JsonResource
{
    public static $wrap = null;

    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    /**
     * Create a new pagination resource collection.
     *
     * @param mixed $resource
     *
     * @return BasePaginationResource
     */
    public static function pagination($resource, $meta = [])
    {
        return tap(new BasePaginationResource($resource, static::class, $meta), function ($collection) {
            if (property_exists(static::class, 'preserveKeys')) {
                $collection->preserveKeys = (new static([]))->preserveKeys === true;
            }
        });
    }

    public function __get($key)
    {
        if ($this->resource instanceof Model) {
            return $this->resource->{$key};
        }

        if (is_array($this->resource) || $this->resource instanceof Collection) {
            return $this->resource[$key] ?? null;
        }

        return null;
    }

    public function getKey()
    {
        if ($this->resource instanceof Model) {
            return $this->resource->getKey();
        }

        if (is_array($this->resource) || $this->resource instanceof Collection) {
            return $this->resource['id'] ?? null;
        }

        return null;
    }
}
