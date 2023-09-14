<?php

namespace App\Elements;

use Illuminate\Support\Arr;
use App\Enum\SystemSettingValueTypeEnum;

class BaseElement
{
    protected $systemSetting;

    protected $all = false;

    protected $key = null;

    protected $onlyDefault = false;

    protected $onlyEnable = true;

    protected $acceptableValues = [];

    public function __construct($systemSetting)
    {
        $this->systemSetting = $systemSetting;
    }

    public function values($path = null, $default = null)
    {
        if (is_array($path)) {
            $path = implode('.', $path);
        }

        $data = $path ? data_get($this->filter(), $path, null) : $this->filter();

        $data = $this->toValue($data, $default);

        return $data;
    }

    // equivalent with values() function
    public function get($path = null, $default = null)
    {
        return $this->values($path, $default);
    }

    public function valueWithoutKeys($path = null, $default = null)
    {
        return array_values($this->values($path, $default) ?? []);
    }

    public function default($path = null, $default = null)
    {
        $this->onlyDefault(true);

        return $this->first($path, $default);
    }

    public function first($path = null, $default = null)
    {
        $values = $this->values(null, $default);

        if (! is_array($values)) {
            return $values;
        }

        $value = reset($values);

        return data_get($value, $path, $default);
    }

    public function getOriginValue($default = null)
    {
        return data_get($this->systemSetting, 'value', $default);
    }

    public function keys($path = null, $default = null)
    {
        $values = $this->values($path, $default);

        if (! is_array($values)) {
            return null;
        }

        return array_keys($values);
    }

    public function filter()
    {
        if (! $this->isValueTypeOf(SystemSettingValueTypeEnum::JSON_TYPE) || $this->all) {
            return $this->getOriginValue();
        }

        if ($this->onlyDefault) {
            return $this->getDefaultValue();
        }

        if ($this->onlyEnable) {
            return Arr::where($this->getOriginValue([]), function ($data) {
                return data_get($data, 'enable', true);
            });
        }

        return $this->getOriginValue();
    }

    public function getDefaultValue()
    {
        return Arr::where($this->getOriginValue([]), function ($data) {
            return data_get($data, 'is_default', false);
        });
    }

    public function toValue($data, $default = null)
    {
        $this->detectAcceptable();

        $isAcceptValue = false;

        // if data is array then acceptable is not empty
        if ($this->isValueTypeOf(SystemSettingValueTypeEnum::JSON_TYPE)) {
            $isAcceptValue = ! empty($data);
        } else {
            // determine if data is === acceptableValue then return null otherwise return casted data (by function `castValue`)

            $acceptableValues = $this->acceptableValues;

            $nullValues = Arr::where($this->nullValues(), function ($nullValue) use ($acceptableValues) {
                return ! in_array($nullValue, $acceptableValues, true);
            });

            $isAcceptValue = ! in_array($data, $nullValues, true);
        }

        // if data is not accept then return default
        if (! $isAcceptValue) {
            return $this->castValue($default);
        }

        return $this->castValue($data);
    }

    protected function detectAcceptable()
    {
        switch ($this->valueType()) {
            case SystemSettingValueTypeEnum::STRING_TYPE:
                $this->acceptAllValues();
                break;
            case SystemSettingValueTypeEnum::NUMBER_TYPE:
                $this->addAcceptableValues([0]);
                break;
            case SystemSettingValueTypeEnum::BOOL_TYPE:
                $this->addAcceptableValues([0, false]);
                break;

            case SystemSettingValueTypeEnum::JSON_TYPE:
                break;
        }

        return $this;
    }

    protected function castValue($data)
    {
        switch ($this->valueType()) {
            case SystemSettingValueTypeEnum::STRING_TYPE:
                $data = (string) $data;
                break;
            case SystemSettingValueTypeEnum::NUMBER_TYPE:
                $data = (float) $data;
                break;
            case SystemSettingValueTypeEnum::BOOL_TYPE:
                $data = (bool) $data;
                break;

            case SystemSettingValueTypeEnum::JSON_TYPE:
                $data = $data;
                break;
        }

        return $data;
    }

    protected function nullValues()
    {
        return [null, 0, false, 'null', 'false', '0', ''];
    }

    public function acceptAllValues()
    {
        $this->acceptableValues = $this->nullValues();

        return $this;
    }

    public function acceptableValues($values = [])
    {
        $this->acceptableValues = $values;

        return $this;
    }

    public function addAcceptableValues($values = [])
    {
        $this->acceptableValues = array_merge($this->acceptableValues, $values);

        return $this;
    }

    public function all()
    {
        $this->all = true;

        return $this;
    }

    public function valueType()
    {
        return data_get($this->systemSetting, 'value_type');
    }

    public function isValueTypeOf($type)
    {
        return data_get($this->systemSetting, 'value_type') == $type;
    }

    public function onlyDefault($bool = true)
    {
        $this->onlyDefault = $bool;

        return $this;
    }

    public function onlyEnable($bool = true)
    {
        $this->onlyEnable = $bool;

        return $this;
    }

    public function when(\Closure $callable)
    {
        return $callable($this);
    }
}
