<?php

namespace App\Models\Traits;

trait HasUpdater
{
    public function updatedBy()
    {
        return $this->morphTo();
    }

    public function getUpdatedByKeyNameColumn()
    {
        return defined('static::UPDATED_BY_KEY_NAME') ? static::UPDATED_BY_KEY_NAME : 'updated_by_id';
    }

    public function getUpdatedByTypeColumn()
    {
        return defined('static::UPDATED_BY_TYPE') ? static::UPDATED_BY_TYPE : 'updated_by_type';
    }
}
