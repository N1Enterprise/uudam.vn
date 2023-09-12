<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use Modules\Core\Enum\TimeZoneEnum;
use Illuminate\Support\Str;
use Modules\Core\Common\Money;
use Modules\Core\Enum\BaseEnum;

if (! function_exists('get_utc_offset')) {
    function getUtcOffset($decryptCookie = false)
    {
        $utcOffset = Request::header('X-Timezone-Offset');

        if(!$utcOffset) {
            $utcOffset = Cookie::get(TimeZoneEnum::UTC_OFFSET_KEY);

            if($utcOffset && $decryptCookie) {
                $utcOffset = explode('|', decrypt($utcOffset, false))[1] ?? 0;
            }
        }

        return $utcOffset ?? 0;
    }
}

if (! function_exists('convert_datetime_To_client_time')) {
    function convert_datetime_To_client_time($date, $revert = false, $timezoneOffset = null)
    {
        $utcOffset = ! is_null($timezoneOffset) ? $timezoneOffset : getUtcOffset();
        $minutes = (int) $utcOffset * ($revert ? -1 : 1);

        return ! empty($date) ? Carbon::parse($date)->addMinutes($minutes) : null;
    }
}

if (! function_exists('boolean')) {
    /**
     * Returns true when value is "1", "true", "on", and "yes". Otherwise, returns false.
     *
     * @param string|null $var
     *
     * @return bool
     */
    function boolean($var = null)
    {
        return filter_var($var, FILTER_VALIDATE_BOOLEAN);
    }
}

if (! function_exists('enum')) {
    /**
     * @param string $name
     * @param string $module
     * @return string
     * @throws BindingResolutionException
     * @throws Exception
     */
    function enum($name, $module = 'System')
    {
        $name = Str::studly($name);
        $module = Str::studly($module);

        $enumClass = implode('\\', ['Modules', $module, 'Enum', $name]);

        $enumInstance = app($enumClass);

        if (! $enumInstance instanceof BaseEnum) {
            throw new \Exception('Invalid enum class '.$enumClass);
        }

        return $enumClass;
    }
}

if (! function_exists('make_array')) {
    function make_array($data)
    {
        return is_array($data) ? $data : [$data];
    }
}

if (! function_exists('pipeline')) {
    /**
     * @return \Illuminate\Pipeline\Pipeline
     */
    function pipeline()
    {
        return app(\Illuminate\Pipeline\Pipeline::class);
    }
}

if (! function_exists('array_filter_empty')) {
    /**
     * @param array $array
     * @param array $emptyValues
     *
     * @return array
     */
    function array_filter_empty(array $array, $emptyValues = [null, ''])
    {
        return array_filter($array, function ($value) use ($emptyValues) {
            return ! in_array($value, $emptyValues, true);
        });
    }
}

if (! function_exists('float_to_string')) {
    /**
     * Convert float to plain string.
     * @param float $float
     * @return string
     * @example $converted
     * 1.0E-8 => "0.00000001"
     */
    function float_to_string($float)
    {
        $norm = strval($float);

        if (($e = strrchr($norm, 'E')) === false) {
            return $norm;
        }

        return number_format($norm, -intval(substr($e, 1)));
    }
}

if (!function_exists('get_utc_offset')) {
    function get_utc_offset($decryptCookie = false)
    {
        $utcOffset = Request::header('X-Timezone-Offset');

        if (!$utcOffset) {
            $utcOffset = Cookie::get(TimeZoneEnum::UTC_OFFSET_KEY);

            if ($utcOffset && $decryptCookie) {
                $utcOffset = explode('|', decrypt($utcOffset, false))[1] ?? 0;
            }
        }

        return $utcOffset ?? 0;
    }
}

if (! function_exists('round_money')) {
    function round_money($money, $currency = null, $round = Money::ROUND_UP)
    {
        return Money::roundMoney($money, $currency, $round);
    }
}
