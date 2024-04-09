<?php

namespace App\Integrations\Oauth;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Enum\OauthTypeEnum;
use App\Enum\SystemSettingKeyEnum;
use App\Exceptions\BusinessLogicException;
use App\Models\OauthPkce;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Support\Str;

abstract class OauthTwoAbstractProvider implements OauthInterface
{
/**
     * The HTTP request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    protected $httpClient;

    /**
     * The client ID.
     *
     * @var string
     */
    public $clientId;

    /**
     * The client secret.
     *
     * @var string
     */
    protected $clientSecret;

    /**
     * The redirect URL.
     *
     * @var string
     */
    protected $redirectUrl;

    /**
     * The FE redirect URL.
     *
     * @var string
     */
    public $playerRedirectUrl;


    /**
     * The custom parameters to be sent with the request.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * The scopes being requested.
     *
     * @var array
     */
    protected $scopes = [];

    /**
     * The separating character for the requested scopes.
     *
     * @var string
     */
    protected $scopeSeparator = ',';

    /**
     * The type of the encoding in the query.
     *
     * @var int Can be either PHP_QUERY_RFC3986 or PHP_QUERY_RFC1738.
     */
    protected $encodingType = PHP_QUERY_RFC1738;

    protected $user;

    protected $setting;

    public function __construct(Request $request, $setting)
    {
		$this->request = $request;
		$this->setupClientRequest();
        $this->setting = $setting;
        $this->clientId = data_get($this->setting, 'client_id');
        $this->clientSecret = data_get($this->setting, 'client_secret');
        $this->redirectUrl = data_get($this->setting, 'redirect_url');
        $this->playerRedirectUrl = data_get($this->setting, 'player_redirect_url');
    }

	public function setupClientRequest()
    {
        $this->httpClient = Http::timeout(30)->acceptJson();

        return $this;
    }

	public function getHttpClient()
	{
		return $this->httpClient;
	}

    public function validated($request)
    {
        return Validator::make($request->all(), [
            'auth_code' => ['required'],
        ])->validate();
    }

    public function resetSession($data = [])
    {

    }

    /**
     * Get the authentication URL for the provider.
     *
     * @param  string  $state
     * @return string
     */
    abstract protected function getAuthUrl();

    /**
     * Get the token URL for the provider.
     *
     * @return string
     */
    abstract protected function getTokenUrl();

    /**
     * Get the raw user for the given access token.
     *
     * @param  string  $token
     * @return array
     */
    abstract protected function getUserByToken($token);

    /**
     * Map the raw user array to a Socialite User instance.
     *
     * @param  array  $user
     * @return array
     */
    abstract protected function mapUserToArray(array $user);

    /**
     * Redirect the user of the application to the provider's authentication screen.
     *
     * @return json
     */
    public function redirect($with = [])
    {
        return response()->json(['redirect_url' => $this->getAuthUrl($with)]);
    }

    public function info($options = [])
    {
        return [
            'provider' => $this->providerName(),
            'authorization_url' => $this->getAuthorizationUrl(data_get($options, 'redirect_params', [])),
            'client_id' => $this->clientId,
            'type' => $this->oauthType(),
        ];
    }

    public function getAuthorizationUrl($with = [])
    {
        return $this->getAuthUrl($with);
    }

    /**
     * Build the authentication URL for the provider from the given base URL.
     *
     * @param  string  $url
     * @param  string  $state
     * @return string
     */
    protected function buildAuthUrlFromBase($url, $with = [])
    {
        return $url.'?'.http_build_query(array_merge($this->getCodeFields(), $this->getRedirectState($with)), '', '&', $this->encodingType);
    }

    public function getRedirectState($with = [])
    {
        return [
            'state' => http_build_query($with),
        ];
    }

    /**
     * Get the GET parameters for the code request.
     *
     * @return array
     */
    protected function getCodeFields()
    {
        $fields = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUrl,
            'scope' => $this->formatScopes($this->getScopes(), $this->scopeSeparator),
            'response_type' => 'code',
        ];

        return array_merge($fields, $this->parameters);
    }

    /**
     * Format the given scopes.
     *
     * @param  array  $scopes
     * @param  string  $scopeSeparator
     * @return string
     */
    protected function formatScopes(array $scopes, $scopeSeparator)
    {
        return implode($scopeSeparator, $scopes);
    }

    /**
     * {@inheritdoc}
     */
    public function user(array $payload)
    {
        $response = $this->getAccessTokenResponse(Crypt::decryptString(data_get($payload, 'auth_code')), Arr::except($payload, ['auth_code']));

        logger('tracking user -> getAccessTokenResponse', [
            '$response' => $response
        ]);

        $user = $this->getUserByToken(data_get($response, 'access_token'));

        logger('tracking user -> getAccessTokenResponse', [
            '$user' => $user
        ]);

        return $this->mapUserToArray($user);
    }

    /**
     * Get a Social User instance from a known access token.
     *
     * @param  string  $token
     * @return array
     */
    public function userFromToken($token)
    {
        $user = $this->mapUserToArray($this->getUserByToken($token));

        return $user;
    }

    /**
     * Get the access token response for the given code.
     *
     * @param  string  $code
     * @return array
     */
    public function getAccessTokenResponse($code, $data = [])
    {
        logger('getAccessTokenResponse', [$this->getTokenFields($code, $data)]);
        $response = $this->getHttpClient()->post($this->getTokenUrl(), $this->getTokenFields($code, $data));

        $response->throw();

        $body = $response->json();

        return $body;
    }

    /**
     * Get the POST fields for the token request.
     *
     * @param  string  $code
     * @return array
     */
    protected function getTokenFields($code, $data = [])
    {
        $fields = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $code,
            'redirect_uri' => $this->redirectUrl,
        ];

        return $fields;
    }

    public function parseRequestData(Request $request): array
    {
        $state = [];

        parse_str($request->get('state'), $state);

        return array_merge(['state' => $state], [
            'auth_code' => Crypt::encryptString($this->request->get('code')),
            'provider'  => $this->providerName(),
        ]);
    }

    /**
     * Merge the scopes of the requested access.
     *
     * @param  array|string  $scopes
     * @return $this
     */
    public function scopes($scopes)
    {
        $this->scopes = array_unique(array_merge($this->scopes, (array) $scopes));

        return $this;
    }

    /**
     * Set the scopes of the requested access.
     *
     * @param  array|string  $scopes
     * @return $this
     */
    public function setScopes($scopes)
    {
        $this->scopes = array_unique((array) $scopes);

        return $this;
    }

    /**
     * Get the current scopes.
     *
     * @return array
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * Set the redirect URL.
     *
     * @param  string  $url
     * @return $this
     */
    public function redirectUrl($url)
    {
        $this->redirectUrl = $url;

        return $this;
    }

    /**
     * Set the request instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    public function oauthType(): string
    {
        return OauthTypeEnum::OAUTH2;
    }

    public function getUserRedirectUrl($data = [])
    {
        $state = Arr::pull($data, 'state', []);

        $url = parse_expression($this->playerRedirectUrl, [
            'fe_host' => Str::of(empty(data_get($state, 'host')) ? config('user.host') : data_get($state, 'host'))->after('://')->__toString()
        ]);

        return $url.'?'.http_build_query(array_merge([
            'path' => data_get($state, 'path', '/'),
        ], $data), '', '&');
    }

    /** @return OauthPkce */
    public function createOauthPkce()
    {
        $codeVerifier = generate_code_verifier();
        $codeChallenge = generate_code_challenge($codeVerifier);

        return OauthPkce::create([
            'oauth_provider_code' => $this->providerName(),
            'code_challenge' => $codeChallenge,
            'code_verifier' => $codeVerifier,
        ]);
    }

    /**
     * @return OauthPkce
     * @throws BusinessLogicException
    */
    public function findOauthPkce($codeChallenge)
    {
        $pkce = OauthPkce::where(['oauth_provider_code' => $this->providerName(), 'code_challenge' => $codeChallenge])->first();

        if (empty($pkce)) {
            throw new BusinessLogicException('[Oauth2] Invalid code challenge');
        }

        return $pkce;
    }

    public function deleteOauthPkce($codeChallenge)
    {
        return OauthPkce::where(['oauth_provider_code' => $this->providerName(), 'code_challenge' => $codeChallenge])->delete();
    }
}
