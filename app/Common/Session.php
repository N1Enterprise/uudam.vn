<?php

namespace App\Common;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session as FacadesSession;

class Session
{
    public $key;

    public $limit = 100;

    public const USER_RECENT_INVENTORIES = 'user_recent_inventories';

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function limit(int $limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return static
     * @throws BindingResolutionException
     */
    public static function make($key)
    {
        return app(static::class, ['key' => $key]);
    }

    public function putRecent($value)
    {
        $items = collect(Arr::wrap($this->get($this->key)))
            ->filter(function($item) use ($value) {
                return $item != $value;
            });

        $items = $items->prepend($value)->take($this->limit);

        FacadesSession::put($this->key, $items->toArray());

        return $this;
    }

    public function get()
    {
        return FacadesSession::get($this->key);
    }

    public function toCollect()
    {
        return collect($this->get());
    }
}
