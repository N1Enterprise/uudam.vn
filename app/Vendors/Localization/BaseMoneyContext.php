<?php

namespace App\Vendors\Localization;;

use Brick\Money\Context;
use Brick\Money\Currency;

use Brick\Math\BigDecimal;
use Brick\Math\BigNumber;

/**
 * Adjusts a number to the default scale for the currency.
 */
final class BaseMoneyContext implements Context
{
    /**
     * The scale of the monies using this context for format rendering.
     *
     * @var int
     */
    private $formatScale;

    /**
     * @param int $scale The scale of the monies using this context.
     * @param int $step  An optional cash rounding step. Must be a multiple of 2 and/or 5.
     */
    public function __construct(int $formatScale = null)
    {
        $this->formatScale = $formatScale;
    }

    /**
     * @inheritdoc
     */
    public function applyTo(BigNumber $amount, Currency $currency, int $roundingMode) : BigDecimal
    {
        return $amount->toScale($currency->getDefaultFractionDigits(), $roundingMode);
    }

    /**
     * {@inheritdoc}
     */
    public function getStep() : int
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function isFixedScale() : bool
    {
        return true;
    }

    public function getFormatScale() : int
    {
        return $this->formatScale;
    }
}
