<?php

namespace App\Integrations\Oauth;

use Illuminate\Support\Arr;

class Google extends OauthTwoAbstractProvider
{
/**
     * The separating character for the requested scopes.
     *
     * @var string
     */
    protected $scopeSeparator = ' ';

    /**
     * The scopes being requested.
     *
     * @var array
     */
    protected $scopes = [
        'openid',
        'profile',
        'email',
    ];

    protected $tokenUrl = 'https://www.googleapis.com/oauth2/v4/token';

	protected $authUrl = 'https://accounts.google.com/o/oauth2/auth';

    protected $userInfoUrl = 'https://www.googleapis.com/oauth2/v3/userinfo';

	protected $user;

    public const PROVIDER_NAME = 'google';

    public function providerName(): string
    {
        return self::PROVIDER_NAME;
    }

	protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()
					->withToken($token)
					->get($this->userInfoUrl, ['prettyPrint' => 'false']);

		$response->throw();

		$body = $response->json();

        return $body;
    }

	protected function getAuthUrl($with = [])
	{
		return $this->buildAuthUrlFromBase($this->authUrl, $with);
	}

	protected function getTokenUrl()
    {
        return $this->tokenUrl;
    }

	protected function mapUserToArray(array $user)
    {
        return [
            'id'       => Arr::get($user, 'sub'),
            'nickname' => Arr::get($user, 'nickname'),
            'name'     => Arr::get($user, 'name'),
            'email'    => Arr::get($user, 'email'),
        ];
    }
}
