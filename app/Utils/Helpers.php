<?php

use App\Classes\AdminAuth;
use App\Common\Money;
use App\Enum\BaseEnum;
use App\Enum\TimeZoneEnum;
use App\Models\BaseModel;
use App\Vendors\Localization\Money as LocalizationMoney;
use App\Vendors\Localization\SystemCurrency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

if (! function_exists('get_model_key')) {
    function get_model_key($model)
    {
        return BaseModel::getModelKey($model);
    }
}

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
    function enum($name)
    {
        $name = Str::studly($name);

        $enumClass = implode('\\', ['App', 'Enum', $name]);

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

if (! function_exists('get_utc_offset')) {
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

if (! function_exists('format_price')) {
    function format_price($money, $currencyCode = null)
    {
        if (empty($money)) {
            return;
        }

        return LocalizationMoney::make($money, $currencyCode ?? SystemCurrency::getDefaultCurrency()->getKey())->format(0, true);
    }
}

if (! function_exists('get_percent')) {
    function get_percent($firstNumber, $secondNumber)
    {
        return round(LocalizationMoney::make($firstNumber,  SystemCurrency::getDefaultCurrency()->getKey())->percentOf($secondNumber));
    }
}


if (! function_exists('generate_combinations'))
{
    /**
     * Generate all the possible combinations among a set of nested arrays.
     *
     * @param  array   $data  The entrypoint array container.
     * @param  array   &$all  The final container (used internally).
     * @param  array   $group The sub container (used internally).
     * @param  int     $k     The actual key for value to append (used internally).
     * @param  string  $value The value to append (used internally).
     * @param  integer $i     The key index (used internally).
     * @param  int     $key   The kay of parent array (used internally).
     * @return array          The result array with all posible combinations.
     */
    function generate_combinations(array $data, array &$all = [], array $group = [], $k = null, $value = null, $i = 0, $key = null)
    {
        $keys = array_keys($data);

        if ((isset($value) === true) && (isset($k) === true)) {
            $group[$key][$k] = $value;
        }

        if ($i >= count($data)){
            array_push($all, $group);
        }
        else {
            $currentKey = $keys[$i];

            $currentElement = $data[$currentKey];

            if(count($currentElement) <= 0){
                generate_combinations($data, $all, $group, null, null, $i + 1, $currentKey);
            }
            else{
                foreach ($currentElement as $k => $val){
                    generate_combinations($data, $all, $group, $k, $val, $i + 1, $currentKey);
                }
            }
        }

        return $all;
    }
}

if (! function_exists('format_datetime')) {
    function format_datetime($datetime, $format = 'd/m/Y')
    {
        if (empty($datetime)) return;
        return date($format, strtotime($datetime));
    }
}

if (! function_exists('display_json_value')) {
    function display_json_value($value, $default = '{}')
    {
        return $value ? json_encode($value, JSON_PRETTY_PRINT) : $default;
    }
}

if (! function_exists('image')) {
    function image($image)
    {
        return $image ?? asset('frontend/assets/images/shared/undefined.jpeg');
    }
}

if (! function_exists('get_file_version')) {
    function get_file_version($file)
    {
        return "{$file}?v=" . date('YmdHis', filemtime(public_path($file)));
    }
}

if (! function_exists('empty_model')) {
    function empty_model($model)
    {
        if (! $model instanceof Model || empty($model)) {
            return redirect()->route('fe.web.home');
        }
    }
}

if (! function_exists('disabled_input')) {
    function disabled_input($bool)
    {
        if ($bool) {
            return 'disabled';
        }
    }
}

if (! function_exists('asset_with_version')) {
    function asset_with_version($pathname)
    {
        return asset($pathname) . '?v=' . config('app.build_version');
    }
}

if (! function_exists('has_data')) {
    function has_data($data)
    {
        if ($data instanceof Collection) {
            return !$data->isEmpty();
        } else if (is_array($data) || is_string($data) || is_numeric($data)) {
            return $data == 0 ? true : !empty($data);
        } else if (is_bool($data)) {
            return $data;
        }

        return false;
    }
}

if (! function_exists('is_webmaster')) {
    function is_webmaster()
    {
        return optional(AdminAuth::user())->id == 1;
    }
}

if (!function_exists('coalesce')) {
    function coalesce(...$args)
    {
        $args = array_filter_empty($args);

        return array_shift($args);
    }
}

if (!function_exists('to_timestamp')) {
    function to_timestamp($date, $precision = 0)
    {
        return (int) round((Carbon::make($date)->rawFormat('Uu')) / pow(10, 6 - $precision));
    }
}

/**
 * parse a string into laravel Stringable
 */
if (!function_exists('to_stringable')) {
    function to_stringable($string)
    {
        return Str::of($string);
    }
}

if (!function_exists('parse_expression')) {
    function parse_expression($string, $replacements, $emptyOnParseError = false, $pattern = '/\$\{([^}]*)\}/')
    {
        $parsed = preg_replace_callback(
            $pattern,
            function ($matches) use ($replacements, $string, $emptyOnParseError) {
                $expressionLanguage = new Symfony\Component\ExpressionLanguage\ExpressionLanguage();
                $expressionLanguage->addFunction(Symfony\Component\ExpressionLanguage\ExpressionFunction::fromPhp('array_search'));
                $expressionLanguage->addFunction(Symfony\Component\ExpressionLanguage\ExpressionFunction::fromPhp('in_array'));
                $expressionLanguage->addFunction(Symfony\Component\ExpressionLanguage\ExpressionFunction::fromPhp('data_get'));
                $expressionLanguage->addFunction(Symfony\Component\ExpressionLanguage\ExpressionFunction::fromPhp('implode'));
                $expressionLanguage->addFunction(Symfony\Component\ExpressionLanguage\ExpressionFunction::fromPhp('coalesce'));
                $expressionLanguage->addFunction(Symfony\Component\ExpressionLanguage\ExpressionFunction::fromPhp('to_timestamp'));
                $expressionLanguage->addFunction(Symfony\Component\ExpressionLanguage\ExpressionFunction::fromPhp('to_stringable'));


                $expression = $matches[1] ?? $matches[0]; // remove string expression wrapper (ex: ${expression} => expression)

                try {
                    $parsed = $expressionLanguage->evaluate(
                        $expression,
                        $replacements
                    );
                } catch (\Throwable $th) {
                    Log::warning('Expression Unable to Parse: ' . $th->getMessage(), ['string' => $string, 'expression' => $expression, 'replacements' => $replacements]);

                    return $emptyOnParseError ? null : $matches[0];
                }

                return $parsed;
            },
            $string
        );

        // cast parsed expression string to another type
        // example expression "${parsedString} $| float"
        // the cast type will get after last `$|` character
        $castType = trim(Str::afterLast($parsed, '$|'));

        $possibleTypes = ['boolean', 'bool', 'integer', 'int', 'float', 'double', 'string', 'array', 'object'];

        if (!in_array($castType, $possibleTypes)) {
            return $parsed;
        }

        settype($parsed, $castType);

        return $parsed;
    }
}

