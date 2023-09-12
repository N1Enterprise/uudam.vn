<?php

namespace App\Models\Traits;

use App\Enum\ActivationStatusEnum;

trait Activatable
{
    public function scopeActive($query)
    {
        return $query->where($this->getActivationStatusColumn(), ActivationStatusEnum::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where($this->getActivationStatusColumn(), ActivationStatusEnum::INACTIVE);
    }

    public function isActive()
    {
        return $this->{$this->getActivationStatusColumn()} == ActivationStatusEnum::ACTIVE;
    }

    public function getStatusNameAttribute()
    {
        return ActivationStatusEnum::findConstantLabel($this->{$this->getActivationStatusColumn()});
    }

    public function getActivationStatusColumn()
    {
        return defined('static::ACTIVATION_STATUS') ? static::ACTIVATION_STATUS : 'status';
    }
}
