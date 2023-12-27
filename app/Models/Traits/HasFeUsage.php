<?php

namespace App\Models\Traits;

use App\Enum\ActivationStatusEnum;

trait HasFeUsage
{
    public function scopeFeDisplay($query)
    {
        return $query->where('display_on_frontend', 1);
    }

    public function scopeFeSearch($query)
    {
        return $query->where('allow_frontend_search', 1);
    }

    public function getDisplayOnFrontendNameAttribute()
    {
        return ActivationStatusEnum::findConstantLabel($this->{$this->getActivationDisplayOnFrontendColumn()});
    }

    public function getAllowFrontendSearchNameAttribute()
    {
        return ActivationStatusEnum::findConstantLabel($this->{$this->getActivationAllowFrontendSearchColumn()});
    }

    public function getActivationDisplayOnFrontendColumn()
    {
        return defined('static::DISPLAY_ON_FRONTEND') ? static::DISPLAY_ON_FRONTEND : 'display_on_frontend';
    }

    public function getActivationAllowFrontendSearchColumn()
    {
        return defined('static::ALLOW_FRONTEND_SEARCH') ? static::ALLOW_FRONTEND_SEARCH : 'allow_frontend_search';
    }
}
