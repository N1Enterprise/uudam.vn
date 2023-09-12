<?php

namespace App\Models\Traits;

trait HasCreator
{
    public function createdBy()
    {
        return $this->morphTo();
    }

    public function getCreatedByKeyNameColumn()
    {
        return defined('static::CREATED_BY_KEY_NAME') ? static::CREATED_BY_KEY_NAME : 'created_by_id';
    }

    public function getCreatedByTypeColumn()
    {
        return defined('static::CREATED_BY_TYPE') ? static::CREATED_BY_TYPE : 'created_by_type';
    }
}
