<?php

namespace App\Exceptions;

class ExceptionCode
{
    public const INVALID_USER = 'invalid_user';
    public const INVALID_CART_ITEM = 'invalid_cart_item';
    public const INVALID_CART = 'invalid_cart';
    public const INVALID_ORDER = 'invalid_order';
    public const UNAUTHORIZED = 'unauthorized';
    public const INVALID_PAYMENT_PROVIDER = 'invalid_payment_provider';
    public const INVALID_TRANSACTION = 'invalid_transaction';
    public const INVALID_USER_CURRENCY = 'invalid_user_currency';
    public const DEACTIVATED_ACCOUNT = 'deactivated_account';
    public const INVALID_PAYMENT_OPTION = 'invalid_payment_option';
    public const INVALID_SHIPPING_OPTION = 'invalid_shipping_option';
}
