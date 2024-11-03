<?php

namespace App\Integrations\Oauth;

use Illuminate\Support\Facades\Http;

class Tiktok extends OauthTwoAbstractProvider
{
    public const PROVIDER_NAME = 'tiktok';

    protected $authUrl = 'https://www.tiktok.com/v2/auth/authorize';

    protected $tokenUrl = 'https://open.tiktokapis.com/v2/oauth/token/';

    protected $userInfoUrl = 'https://open.tiktokapis.com/v2/user/info/';

    protected $fields = [
        'open_id',
        'union_id',
        'avatar_url',
        'display_name'
    ];

    public function providerName(): string
    {
        return self::PROVIDER_NAME;
    }

    protected function getAuthUrl($with = [])
	{
		return $this->buildAuthUrlFromBase($this->authUrl, $with);
	}

    public function getHttpClient()
	{
		return Http::timeout(30)
            ->acceptJson()
            ->asForm();
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

    protected function getTokenFields($code, $data = [])
    {
        return [
            'client_key' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->redirectUrl
        ];
    }

    protected function getUserByToken($token)
    {
        $params = [
            'fields' => implode(',', $this->fields),
        ];

        $response = Http::timeout(30)
            ->acceptJson()
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$token
            ])
            ->get($this->userInfoUrl, $params);

        $response->throw();

        $data = $response->json();

        return $data;
    }

    protected function mapUserToArray(array $user)
    {
        return [
            'id' => data_get($user, 'data.user.union_id'),
            'nickname' => data_get($user, 'data.user.username'),
            'name' => data_get($user, 'data.user.display_name')
        ];
    }
}
