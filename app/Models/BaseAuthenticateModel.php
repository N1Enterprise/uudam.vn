<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

abstract class BaseAuthenticateModel extends Authenticatable
{
    public function getCreatedAtLocalizedAttribute()
    {
        return convert_datetime_To_client_time($this->created_at);
    }

    public function getUpdatedAtLocalizedAttribute()
    {
        return convert_datetime_To_client_time($this->updated_at);
    }
}
