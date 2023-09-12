<?php

namespace App\Models\Traits;

trait HasImpactor
{
    use HasCreator;
    use HasUpdater;

    public static function bootHasImpactor()
    {
        static::creating(function ($model) {
            if ($model->hasImpactCreator() && ! $model->created_by_id) {
                $model->createdBy ?: $model->createdBy()->associate(request()->user());
            }

            if ($model->hasImpactUpdater() && ! $model->updated_by_id) {
                $model->updatedBy ?: $model->updated_by_id ?? $model->updatedBy()->associate($model->createdBy ?? request()->user());
            }
        });

        static::updating(function ($model) {
            $loadedUpdater = $model->isDirty($model->getUpdatedByKeyNameColumn()) || $model->isDirty($model->getUpdatedByTypeColumn());

            if (!$loadedUpdater && $model->hasImpactUpdater() && $model->isDirty() && request()->user()) {
                $model->updatedBy()->dissociate();
                $model->updatedBy()->associate(request()->user());
            }
        });
    }

    public function hasImpactUpdater()
    {
        return defined('static::HAS_UPDATER') ? static::HAS_UPDATER : true;
    }

    public function hasImpactCreator()
    {
        return defined('static::HAS_CREATOR') ? static::HAS_CREATOR : true;
    }
}
