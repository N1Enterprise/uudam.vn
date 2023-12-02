<?php

namespace App\Models\Traits;

trait HasFeUsage
{
    public function scopeFeDisplay($query)
    {
        return $query->where('display_on_frontend', 1);
    }
}
