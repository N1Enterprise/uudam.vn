<?php

namespace App\Integrations\Oauth;

class Zalo extends OauthTwoAbstractProvider
{
    public const PROVIDER_NAME = 'zalo';

    public function providerName(): string
    {
        return self::PROVIDER_NAME;
    }

    protected function getAuthUrl($with = [])
    {
    }

    protected function getTokenUrl()
    {
    }

    protected function getUserByToken($token)
    {
    }

    protected function mapUserToArray(array $user)
    {
        return [
        ];
    }
}