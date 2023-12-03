<?php

namespace App\Payment\Contracts;

interface ProviderNamingContract
{
    public static function providerName(): string;

    public static function providerCode(): string;
}
