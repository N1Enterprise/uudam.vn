<?php

use App\Classes\AdminAuth;
use App\Common\Money;
use App\Enum\BaseEnum;
use App\Enum\SystemSettingKeyEnum;
use App\Enum\TimeZoneEnum;
use App\Models\BaseModel;
use App\Models\SystemSetting;
use App\Vendors\Localization\Money as LocalizationMoney;
use App\Vendors\Localization\SystemCurrency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
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
        if (is_null($money) || $money == 0) {
            return;
        }

        return LocalizationMoney::make($money, $currencyCode ?? SystemCurrency::getDefaultCurrency()->getKey())->format(0, true);
    }
}

if (! function_exists('get_percent')) {
    function get_percent($firstNumber, $secondNumber = null)
    {
        return round(100 - LocalizationMoney::make($secondNumber,  SystemCurrency::getDefaultCurrency()->getKey())->percentOf($firstNumber));
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
        } else if ($data instanceof Model) {
            return true;
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

if (! function_exists('get_static_page_seo_title'))
{
    function get_static_page_seo_title($staticPage, $replaces = [])
    {
        $staticPagesMetaSeo = SystemSetting::from(SystemSettingKeyEnum::STATIC_PAGES_META_SEO)->get(null, []) ?? [];

        $metaSeo = data_get($staticPagesMetaSeo, $staticPage);

        if (empty($metaSeo)) {
            return '';
        }

        return strtr(data_get($metaSeo, 'title'), Arr::wrap($replaces));
    }
}

if (! function_exists('generate_static_page_seo_html'))
{
    function generate_static_page_seo_html($staticPage, $replaces = [])
    {
        $staticPagesMetaSeo = SystemSetting::from(SystemSettingKeyEnum::STATIC_PAGES_META_SEO)->get(null, []) ?? [];

        $metaSeo = data_get($staticPagesMetaSeo, $staticPage);

        if (empty($metaSeo)) {
            return generate_seo_html([]);
        }

        return generate_seo_html([
            'title' => strtr(data_get($metaSeo, 'title'), Arr::wrap($replaces)),
            'desc'  => strtr(data_get($metaSeo, 'desc'), Arr::wrap($replaces)),
            'image' => data_get($metaSeo, 'image'),
            'url'   => request()->url()
        ]);
    }
}

/**
 * parse a string into laravel Stringable
 */
if (! function_exists('generate_seo_html')) {

    function generate_seo_html($properties = [])
    {
        $__page   = data_get($properties, 'page_name');
        $__image  = SystemSetting::from(SystemSettingKeyEnum::SHOP_LOGOS)->get('seo.image');

        $properties = [
            'keywords'            => data_get($properties, 'title') ?? "$__page",
            'og:title'            => data_get($properties, 'title') ?? "$__page",
            'description'         => data_get($properties, 'desc')  ?? "$__page",
            'og:description'      => data_get($properties, 'desc')  ?? "$__page",
            'og:image'            => data_get($properties, 'image') ?? $__image,
            'og:image:secure_url' => data_get($properties, 'image') ?? $__image,
            'url'                 => data_get($properties, 'url')   ?? request()->url(),
            'og:price:amount'     => data_get($properties, 'amount'),
            'og:price:currency'   => data_get($properties, 'amount') ? 'VND' : null,
        ];

        foreach ($properties as $property => $content) {
            if ($content !== null) {
                $tags[$property] = $content;
            }
        }

        $tags['og:site_name'] = config('app.user_domain');
        $tags['og:type'] = 'website';
        $tags['og:locale'] = 'vi_VN';

        $htmls = '';

        foreach ($tags as $property => $content) {
            $htmls .= '<meta name="'.$property.'" content="'.$content.'">';
        }

        return $htmls;
    }
}

if (! function_exists('text_without_spaces')) {
    function text_without_spaces($string)
    {
        return preg_replace('/\s+/', '', $string);
    }
}

if (! function_exists('generate_code_verifier')) {
    function generate_code_verifier() {
        $code = random_bytes(32);
        $verifier = rtrim(strtr(base64_encode($code), '+/', '-_'), '=');

        return $verifier;
    }
}

if (! function_exists('generate_code_challenge')) {
    function generate_code_challenge($codeVerifier) {
        try {
            $bytes = mb_convert_encoding($codeVerifier, 'ASCII');
            $digest = hash('sha256', $bytes, true);
            $result = rtrim(strtr(base64_encode($digest), '+/', '-_'), '=');
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            $result = null;
        }
        return $result;
    }
}

if (!function_exists('hide_phone_number')) {
    function hide_phone_number($phone_number)
    {
        // Chuyển số điện thoại thành chuỗi để dễ xử lý
        $phone_str = (string) $phone_number;

        // Kiểm tra xem số điện thoại có ít nhất 7 chữ số hay không
        if (strlen($phone_str) >= 7) {
            // Ẩn số điện thoại, chỉ hiển thị 3 chữ số đầu và 2 chữ số cuối
            $hidden_number = substr($phone_str, 0, 3) . "*****" . substr($phone_str, -2);
            return $hidden_number;
        } else {
            // Trả về số điện thoại không thay đổi nếu có ít hơn 7 chữ số
            return $phone_str;
        }
    }
}
