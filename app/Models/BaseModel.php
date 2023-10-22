<?php

namespace App\Models;

use App\Exceptions\ModelNotFoundException;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    public static function getMorphProperty($name, Model $model = null)
    {
        if (! $model) {
            return [
                "{$name}_type" => null,
                "{$name}_id" => null,
            ];
        }

        return [
            "{$name}_type" => Model::getActualClassNameForMorph(get_class($model)),
            "{$name}_id" => $model->getKey(),
        ];
    }

    public static function throwNotFound($modelClass = null, $modelKey = null, $message = null)
    {
        throw new ModelNotFoundException($message ?? 'Invalid ' .($modelClass ? class_basename($modelClass).' ' : 'Model with given id: ').BaseModel::getModelKey($modelKey));
    }

    public static function getModelKey($model)
    {
        if ($model instanceof Model) {
            return $model->getKey();
        }

        if (is_array($model) || is_object($model)) {
            return data_get($model, 'id');
        }

        return $model;
    }

    public function getCreatedAtIsoAttribute()
    {
        return convert_datetime_To_client_time($this->created_at)->toISOString();
    }

    public function getUpdatedAtIsoAttribute()
    {
        return convert_datetime_To_client_time($this->updated_at)->toISOString();
    }

    public function getCreatedAtLocalizedAttribute()
    {
        return convert_datetime_To_client_time($this->created_at);
    }

    public function getUpdatedAtLocalizedAttribute()
    {
        return convert_datetime_To_client_time($this->updated_at);
    }

    public function saveOriginalOnly($withFields = [])
    {
        $dirties = $this->getDirty();
        $originalFields = array_merge(
            array_keys($this->getOriginal()),
            array_filter($withFields ?? [])
        );

        foreach ($this->getAttributes() as $key => $value) {
            if (! in_array($key, $originalFields)) {
                unset($this->$key);
            } else {
                unset($dirties[$key]);
            }
        }

        $model = $this->save();

        foreach ($dirties as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $model;
    }

    public function getRawAttribute($key, $default = null)
    {
        return $this->attributes[$key] ?? $default;
    }
}
