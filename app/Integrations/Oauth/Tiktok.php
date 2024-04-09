<?php

namespace App\Integrations\Oauth;

use App\Models\OauthPkce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Tiktok extends OauthTwoAbstractProvider
{
    public const PROVIDER_NAME = 'tiktok';

    protected $authUrl = 'https://www.tiktok.com/v2/auth/authorize';

    protected $tokenUrl = 'https://open.tiktokapis.com/v2/oauth/token';

    protected $userInfoUrl = 'https://open.tiktokapis.com/v2/user/info';

    protected $fields = [
        'id',
        'name',
    ];

    public function providerName(): string
    {
        return self::PROVIDER_NAME;
    }

    protected function getAuthUrl($with = [])
	{
		return $this->buildAuthUrlFromBase($this->authUrl, $with);
	}

    protected function getCodeFields()
    {
        return [
            'client_key' => $this->clientId,
            'scope' => 'user.info.basic',
            'redirect_uri' => $this->redirectUrl,
            'response_type' => 'code',
        ];
    }

    protected function getTokenUrl()
    {
        return $this->tokenUrl;
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
