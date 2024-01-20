<?php

namespace App\Shipping\Contracts;

interface ProviderNamingContract
{
    public static function providerName(): string;

    public static function providerCode(): string;
}
