<?php

namespace App\Models\Traits;

use App\Enum\ActivationStatusEnum;

trait HasFeUsage
{
    public function scopeFeDisplay($query)
    {
        return $query->where('display_on_frontend', 1);
    }

    public function getDisplayOnFrontendNameAttribute()
    {
        return ActivationStatusEnum::findConstantLabel($this->{$this->getActivationDisplayOnFrontendColumn()});
    }

    public function getActivationDisplayOnFrontendColumn()
    {
        return defined('static::DISPLAY_ON_FRONTEND') ? static::DISPLAY_ON_FRONTEND : 'display_on_frontend';
    }
}
