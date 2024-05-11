<?php

namespace App\Common;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Session as FacadesSession;

class Session
{
    public $key;

    public const USER_RECENT_INVENTORIES = 'user_recent_inventories';

    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @return static
     * @throws BindingResolutionException
     */
    public static function make($key)
    {
        return app(static::class, ['key' => $key]);
    }

    public function put($value)
    {
        FacadesSession::put($this->key, $value);
    }

    public function get()
    {
        return FacadesSession::get($this->key);
    }
}
