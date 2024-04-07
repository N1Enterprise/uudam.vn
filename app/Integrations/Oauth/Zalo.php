<?php

namespace App\Integrations\Oauth;
use Illuminate\Support\Facades\Http;

class Zalo extends OauthTwoAbstractProvider
{
    public const PROVIDER_NAME = 'zalo';

    protected $authUrl = 'https://oauth.zaloapp.com/v4/permission';

    protected $tokenUrl = 'https://oauth.zaloapp.com/v4/access_token';

    protected $userInfoUrl = 'https://graph.zalo.me/v2.0/me';

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

    protected function getTokenUrl()
    {
        return $this->tokenUrl;
    }

    protected function getUserByToken($token)
    {
        $params = [
            'fields' => implode(',', $this->fields),
        ];

        $response = Http::timeout(30)
            ->acceptJson()
            ->withHeaders(['access_token' => $token])
            ->get($this->userInfoUrl, $params);

        $response->throw();

        $data = $response->json();

        return $data;
    }

    protected function mapUserToArray(array $user)
    {
        return [
            'id' => data_get($user, 'id'),
            'nickname' => null,
            'name' => data_get($user, 'name'),
        ];
    }

    protected function getCodeFields()
    {
        return [
            'app_id' => $this->clientId,
            'redirect_uri' => $this->redirectUrl,
            'code_challenge' => $this->getCodeChallenge(),
        ];
    }

    protected function getCodeVerifier()
    {
        return data_get($this->setting, 'code_verifier', 'Cec1fUiTwYS2c0');
    }

    protected function getCodeChallenge()
    {
        return rtrim(base64_encode(hash('sha256', $this->getCodeVerifier(), true)), '=');
    }

    public function getHttpClient()
	{
		return Http::timeout(30)
            ->acceptJson()
            ->asForm()
            ->withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'secret_key' => $this->clientSecret
            ]);
	}

    protected function getTokenFields($code)
    {
        return [
            'code' => $code,
            'app_id' => $this->clientId,
            'grant_type' => 'authorization_code',
            'code_verifier' => $this->getCodeVerifier()
        ];
    }
}
