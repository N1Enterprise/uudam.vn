<?php

namespace App\Common;

class Money
{
    public const MONEY_DECIMALS = 2;
    public const ROUND_UP = 'up';

    public static function parse($amount, $currency = null, $round = 'up')
    {
        return floatval($amount);
    }

    public static function subtract($amount, $subtractAmount, $currency = null, $round = 'up')
    {
        return static::parse($amount) - static::parse($subtractAmount);
    }

    public static function isBetween($amount, $from = 0, $to = null, $reverse = false)
    {
        if ($reverse && $to < $from) {
            if ($to === null) {
                return $amount >= $from;
            }

            $tempFrom = $from;
            $from = $to;
            $to = $tempFrom;
        }

        if ($to === null) {
            return $amount >= $from;
        }

        return $amount >= $from && $amount <= $to;
    }

    public static function eq($amount, $compareAmount)
    {
        return static::parse($amount) == static::parse($compareAmount);
    }

    public static function gt($amount, $compareAmount)
    {
        return static::parse($amount) > static::parse($compareAmount);
    }

    public static function gte($amount, $compareAmount)
    {
        return static::parse($amount) >= static::parse($compareAmount);
    }

    public static function lt($amount, $compareAmount)
    {
        return static::parse($amount) < static::parse($compareAmount);
    }

    public static function lte($amount, $compareAmount)
    {
        return static::parse($amount) <= static::parse($compareAmount);
    }

    public static function max(...$amounts)
    {
        $amounts = array_map(function($amount) {
            return static::parse($amount);
        }, $amounts);

        return max($amounts);
    }

    public static function min(...$amounts)
    {
        $amounts = array_map(function($amount) {
            return static::parse($amount);
        }, $amounts);

        return min($amounts);
    }

    public static function allocate($total, ...$percents)
    {
        $result = [];

        foreach ($percents as $percent) {
            $result[] = static::percentOf($total, $percent);
        }

        return $result;
    }

    /**
     * reverse of function allocate.
     *
     * @param mixed $total
     * @param mixed $numbers
     */
    public static function dislocate($total, ...$numbers)
    {
        $result = [];

        foreach ($numbers as $number) {
            $result[] = static::parse((static::parse($number) * 100) / static::parse($total));
        }

        return $result;
    }

    public static function percentOf($amount, $percent)
    {
        return static::parse((static::parse($amount) * $percent) / 100);
    }

    public static function sum(...$amounts)
    {
        $amounts = array_map(function($amount) {
            return static::parse($amount);
        }, $amounts);

        return array_sum($amounts);
    }

    /**
     * @param $amount
     * @param null   $currency
     * @param string $round
     *
     * @return float
     */
    public static function roundMoney($amount, $currency = null, $round = self::ROUND_UP)
    {
        return floatval(round($amount, self::MONEY_DECIMALS,
            ($round == self::ROUND_UP) ? PHP_ROUND_HALF_UP : PHP_ROUND_HALF_DOWN));
    }

    public static function format($amount, $decimals = self::MONEY_DECIMALS, $decimal_separator = '.', $thousands_separator = ',')
    {
        return number_format(self::roundMoney($amount), $decimals, $decimal_separator, $thousands_separator);
    }
}
