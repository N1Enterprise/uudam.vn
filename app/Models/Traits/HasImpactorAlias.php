<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasImpactorAlias
{
    public function getImpactorAliasAttribute()
    {
        return Str::of(class_basename($this))->snake()->plural();
    }
}
