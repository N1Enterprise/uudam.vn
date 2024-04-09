<?php

namespace App\Integrations\Oauth;

use App\Models\OauthPkce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

        logger('tracking getUserByToken', [
            '$params' => $params
        ]);

        $response = Http::timeout(30)
            ->acceptJson()
            ->withHeaders(['access_token' => $token])
            ->get($this->userInfoUrl, $params);

        $response->throw();

        $data = $response->json();

        logger('tracking getUserByToken', [
            '$data' => $data
        ]);

        return $data;
    }

    protected function mapUserToArray(array $user)
    {
        logger('mapUserToArray', [$user]);

        return [
            'id' => data_get($user, 'id'),
            'nickname' => null,
            'name' => data_get($user, 'name'),
        ];
    }

    protected function getCodeFields()
    {
        $oauthPkce = $this->createOauthPkce();

        logger('tracking oauthPkce', [$oauthPkce->toArray()]);

        return [
            'app_id' => $this->clientId,
            'redirect_uri' => $this->redirectUrl,
            'code_challenge' => data_get($oauthPkce, 'code_challenge'),
        ];
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

    public function parseRequestData(Request $request): array
    {
        $data = parent::parseRequestData($request);

        return array_merge($data, [
            'code_challenge' => $request->code_challenge
        ]);
    }

    public function validated($request)
    {
        return Validator::make($request->all(), [
            'auth_code' => ['required'],
            'code_challenge' => ['required', Rule::exists(OauthPkce::class, 'code_challenge')]
        ])->validate();
    }

    protected function getTokenFields($code, $data = [])
    {
        $codeVerifier = $this->getCodeVerifierPkce(data_get($data, 'code_challenge'));

        return [
            'code' => $code,
            'app_id' => $this->clientId,
            'grant_type' => 'authorization_code',
            'code_verifier' => $codeVerifier
        ];
    }

    public function resetSession($data = [])
    {
        $this->deleteOauthPkce(data_get($data, 'code_challenge'));
    }
}
