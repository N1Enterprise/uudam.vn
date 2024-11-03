<?php

namespace App\Vendors\Localization;

use Brick\Math\BigDecimal;
use Brick\Math\BigNumber;
use Brick\Math\RoundingMode;
use Brick\Money\Currency;
use Brick\Money\Exception\MoneyMismatchException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Brick\Money\Money as BrickMoney;
use Illuminate\Support\Traits\ForwardsCalls;
use App\Models\SystemCurrency as SystemCurrencyEntity;
/**
 * Used to interact Brick Money
 *
 * @method Money plus(int|float|string $amount, int $roundingMode = 0)
 * @method Money minus(int|float|string $amount, int $roundingMode = 0)
 * @method Money multipliedBy(int|float|string $amount, int $roundingMode = 0)
 * @method Money dividedBy(int|float|string $amount, int $roundingMode = 0)
 * @method Money[] allocate(int ...$ratios)
 * @method Money[] split(int $parts)
 * @method Money abs()
 * @method Money negated()
 */
class Money
{
    use ForwardsCalls;

    public const ROUND_UNNECESSARY = RoundingMode::UNNECESSARY;

    public const ROUND_UP = RoundingMode::UP;

    public const ROUND_DOWN = RoundingMode::DOWN;

    public const ROUND_CEILING = RoundingMode::CEILING;

    public const ROUND_FLOOR = RoundingMode::FLOOR;

    public const ROUND_HALF_UP = RoundingMode::HALF_UP;

    public const ROUND_HALF_DOWN = RoundingMode::HALF_DOWN;

    public const ROUND_HALF_CEILING = RoundingMode::HALF_CEILING;

    public const ROUND_HALF_FLOOR = RoundingMode::HALF_FLOOR;

    public const ROUND_HALF_EVEN = RoundingMode::HALF_EVEN;

    protected BrickMoney $money;

    protected SystemCurrencyEntity $systemCurrency;

    protected ?BrickMoney $convertedFrom;

    protected ?string $convertedRate;

    public function __construct() {
    }

    /**
     * @param mixed $amount
     * @param string $currency
     * @param int|null $decimals
     * @return static
     * @throws BindingResolutionException
     */
    public static function make($amount, $currencyCode, $roundingMode = self::ROUND_DOWN, $ofMinor = false)
    {
        if($amount instanceof static) {
            return $amount;
        }

        /** @var static */
        $static = app(static::class);

        $systemCurrency = SystemCurrency::get($currencyCode);

        $currency = $static->toBrickCurrency($systemCurrency);

        $moneyContext = new BaseMoneyContext($systemCurrency->decimals);

        $money = $ofMinor ? BrickMoney::ofMinor($amount, $currency, $moneyContext, $roundingMode) : BrickMoney::of($amount, $currency, $moneyContext, $roundingMode);

        $static->money = $money;

        $static->systemCurrency = $systemCurrency;

        return $static;
    }

    public static function makeFromMinorAmount($amount, $currencyCode, $roundingMode = self::ROUND_DOWN)
    {
        return static::make($amount, $currencyCode, $roundingMode, true);
    }

    /**
     * create an money instance by amount only
     *
     * @param int|float|string $amount
     * @param int $roundMode
     * @return static
     */
    public function createFromAmount($amount, $roundingMode = self::ROUND_DOWN)
    {
        return static::make($amount, $this->getSystemCurrency() ?? $this->getCurrencyCode(), $roundingMode);
    }

    public function convertedTo($currencyCode, $rate, $roundingMode = self::ROUND_DOWN)
    {
        $systemCurrency = SystemCurrency::get($currencyCode);

        $brickCurrency = $this->toBrickCurrency($systemCurrency);

        $money = $this->getMoney()->convertedTo($brickCurrency, (string) $rate, null, $roundingMode);

        return static::make($money->getAmount(), $systemCurrency)
            ->setConvertedFrom($this->getMoney())
            ->setConvertedRate($rate);
    }

    public function setConvertedFrom(BrickMoney $money)
    {
        $this->convertedFrom = $money;

        return $this;
    }

    public function setConvertedRate($rate)
    {
        $this->convertedRate = (string) $rate;

        return $this;
    }

    public function toBrickCurrency($currencyCode, $fallbackDefaultCurrency = false)
    {
        $systemCurrency = SystemCurrency::get($currencyCode, $fallbackDefaultCurrency);

        // fixed 18 decimal places for crypto currency
        return new Currency($systemCurrency->getKey(), 0, $systemCurrency->name, $systemCurrency->decimals);
    }

    public function getMoney()
    {
        return $this->money;
    }

    /**
     * @return BaseMoneyContext
     */
    public function getContext()
    {
        return $this->getMoney()->getContext();
    }

    public function getSystemCurrency()
    {
        return $this->systemCurrency;
    }

    public function getAmount()
    {
        return $this->money->getAmount();
    }

    public function getMinorAmount()
    {
        return $this->getMoney()->getMinorAmount();
    }

    public function getConvertedFrom()
    {
        return $this->convertedFrom;
    }

    public function getConvertedRate()
    {
        return $this->convertedRate;
    }

    public function getCurrencyCode()
    {
        return $this->money->getCurrency()->getCurrencyCode();
    }

    /**
     *
     * @param string $percent
     * @return Money
     */
    public function percentFor(string $percent)
    {
        $that = BigDecimal::of($percent)->dividedBy(100, 20, self::ROUND_HALF_UP);

        $amount = $this->getAmount()->multipliedBy($that);

        return $this->createFromAmount($amount, self::ROUND_DOWN);
    }

    /**
     * The percentage of amount compared to current total money amount
     * @param int|float|string $amount
     * @return string percentage
     */
    public function percentOf($amount)
    {
        if($this->eq(0)) {
            return $this->getAmount()->__toString();
        }

        $amount = $this->createFromAmount($amount)->getMoney()->getAmount();

        return $amount->multipliedBy(100)
            ->dividedBy($this->getMoney()->getAmount(), 20, self::ROUND_HALF_UP)
            ->__toString();
    }

    /**
     * The percentage of amount compared to current total money amount
     * @param int|float|string $amount
     * @return string[] percentages
     */
    public function percentOfWithRemainder($amount)
    {
        $remainder = BigDecimal::of(100);

        $amount = $this->createFromAmount($amount)->getMoney()->getAmount();

        $amount = $amount->multipliedBy(100)->dividedBy($this->getMoney()->getAmount(), 20, self::ROUND_HALF_UP);

        $remainder = $remainder->minus($amount);

        return [$amount->__toString(), $remainder->__toString()];
    }

    public function toFloat()
    {
        return $this->getMoney()->getAmount()->toFloat();
    }

    /**
     * @param Money|BigNumber|int|float|string $amount
     * @return bool
     * @throws MoneyMismatchException
     */
    public function lt($amount)
    {
        $amount = $this->parseAmount($amount);

        return $this->getMoney()->isLessThan($amount);
    }

    /**
     * @param Money|BigNumber|int|float|string $amount
     * @return bool
     * @throws MoneyMismatchException
     */
    public function lte($amount)
    {
        $amount = $this->parseAmount($amount);

        return $this->getMoney()->isLessThanOrEqualTo($amount);
    }

    /**
     * @param Money|BigNumber|int|float|string $amount
     * @return bool
     * @throws MoneyMismatchException
     */
    public function eq($amount)
    {
        $amount = $this->parseAmount($amount);

        return $this->getMoney()->isEqualTo($amount);
    }

    /**
     * @param Money|BigNumber|int|float|string $amount
     * @return bool
     * @throws MoneyMismatchException
     */
    public function gt($amount)
    {
        $amount = $this->parseAmount($amount);

        return $this->getMoney()->isGreaterThan($amount);
    }

    /**
     * @param Money|BigNumber|int|float|string $amount
     * @return bool
     * @throws MoneyMismatchException
     */
    public function gte($amount)
    {
        $amount = $this->parseAmount($amount);

        return $this->getMoney()->isGreaterThanOrEqualTo($amount);
    }


    /**
     * @param Money|BigNumber|int|float|string $min
     * @param Money|BigNumber|int|float|string $max
     * @return bool
     * @throws MoneyMismatchException
     */
    public function between($min, $max = null)
    {
        $min = $this->parseAmount($min);

        if($max === null) {
            return $this->getMoney()->isGreaterThanOrEqualTo($min);
        }

        $max = $this->parseAmount($max);

        return $this->getMoney()->isGreaterThanOrEqualTo($min) && $this->getMoney()->isLessThanOrEqualTo($max);
    }

    public function __toString()
    {
        return (string) $this->getMoney()->getAmount();
    }

    /**
     * @param Money|BigNumber|int|float|string $amount
     * @return mixed
     * @throws MoneyMismatchException
     */
    public function parseAmount($amount)
    {
        if($amount instanceof static) {
            // try to determine the $amount is same currency, its not make any changes of this instance
            $this->plus($amount->getMoney());

            $amount = $amount->getMoney();
        }

        return $amount;
    }

    /**
     * @param int $fractionalPartLength minimum fractional part => amount 10 => 10.00 (with $fractionalPartLength = 2)
     * @param bool $currencyCodeSuffix should add currency code as suffix of amount => 10.00 BTC
     * @param bool $realFractionalPart return maximum fractional part based on currency decimals if this param is false
     * @param bool $removeTrailingZero remove trailing zero of fractional part when set to true
     * @param string $decimalsSeparator
     * @return string
     */
    public function format($fractionalPartLength = 0, $currencyCodeSuffix = true, $realFractionalPart = false, $removeTrailingZero = true, $decimalsSeparator = '.')
    {
        $integralPart = $this->getAmount()->getIntegralPart();
        $fractionalPart = $this->getAmount()->getFractionalPart();

        $fractionalPart = $realFractionalPart ? $fractionalPart : substr($fractionalPart, 0, $this->getContext()->getFormatScale());

        $fractionalPart = $removeTrailingZero ? preg_replace('/\.?0+$/', '', $fractionalPart) : $fractionalPart;

        if($fractionalPartLength !== null) {
            $fractionalPart = strlen($fractionalPart) < $fractionalPartLength ? str_pad($fractionalPart, $fractionalPartLength, '0') : $fractionalPart;
        }

        $formatIntegralPart = $integralPart === '-0' ? '-' . number_format($integralPart, 0) : number_format($integralPart, 0);

        $formatted = $formatIntegralPart . (!empty($fractionalPart) ? $decimalsSeparator . $fractionalPart : '');

        return $currencyCodeSuffix ? $formatted . '₫' : $formatted;
    }

    public function __call($method, $arguments)
    {
        // if the arguments instance of money localization so we will parse this to brick money for calculation.
        $arguments = array_map(function($arg) {
            if($arg instanceof static) {
                return $arg->getMoney();
            }

            return $arg;
        }, $arguments);

        $called = $this->forwardCallTo(
            $this->getMoney(), $method, $arguments
        );

        if ($called instanceof BrickMoney) {
            return static::make($called->getAmount(), $this->getSystemCurrency() ?? $called->getCurrency()->getCurrencyCode());
        }

        return $called;
    }
}
