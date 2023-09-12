<?php

namespace App\Enum;

use Illuminate\Support\Str;
use ReflectionClass;

abstract class BaseEnum
{
    abstract public static function all(): array;

    public static function isValid($key = null, $acceptNull = false)
    {
        if ($key == null && $acceptNull) {
            return true;
        }

        return in_array($key, static::all());
    }

    public static function constants(): array
    {
        $class = new ReflectionClass(static::class);

        return $class->getConstants();
    }

    public static function constant($name)
    {
        $class = new ReflectionClass(static::class);

        return $class->getConstant($name);
    }

    public static function keys(): array
    {
        return array_keys(static::all());
    }

    public static function find($key)
    {
        return static::all()[$key] ?? null;
    }

    public static function labels($translate = true): array
    {
        return static::labelsOf(static::constants(), $translate);
    }

    public static function findConstantLabel($key, $translate = true)
    {
        return static::labels($translate)[$key] ?? null;
    }

    public static function findConstantName($key)
    {
        return array_search($key, static::constants()) ?: null;
    }

    public static function modelings($translate = true): array
    {
        return static::modelingsOf(static::constants(), $translate);
    }

    public static function findModeling($id, $translate = true)
    {
        return collect(static::modelings($translate))->where('id', $id)->first();
    }

    public static function allExcept($keys)
    {
        $keys = (array) $keys;

        return array_filter(static::all(), function ($value) use ($keys) {
            return ! in_array($value, $keys);
        });
    }

    public static function labelsOf($all = [], $translate = true): array
    {
        $guessedLabels = [];

        $definedLabels = property_exists(static::class, 'labels') ? (array) static::$labels : [];

        foreach ($all as $value) {
            $label = $definedLabels[$value] ?? str_replace('_', ' ', Str::title(static::findConstantName($value)));

            $guessedLabels[$value] = $translate ? __($label) : $label;
        }

        return $guessedLabels;
    }

    public static function modelingsOf($all = [], $translate = true): array
    {
        $data = [];

        foreach ($all as $value) {
            $model = [
                'id' => $value,
                'name' => static::findConstantLabel($value, $translate),
                'name_constant' => static::findConstantName($value),
                'code' => Str::lower(static::findConstantName($value)),
            ];

            $data[] = $model;
        }

        return $data;
    }

    /**
     * @return static
     */
    public static function make()
    {
        return app(static::class);
    }
}
