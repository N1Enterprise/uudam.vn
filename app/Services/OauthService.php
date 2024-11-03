<?php

namespace App\Services;

use App\Common\IntegrationClassResolver;
use App\Enum\SystemSettingKeyEnum;
use App\Services\BaseService;
use Illuminate\Http\Request;

class OauthService extends BaseService
{
    /**
     * @var \App\Integrations\Oauth\OauthTwoAbstractProvider
     */
    public $provider;

    public function __construct($providerName = null)
    {
        $this->provider = IntegrationClassResolver::make('Oauth', SystemSettingKeyEnum::SUPPORTED_OAUTH_PROVIDERS, $providerName)->resolve();
    }

    public static function of($provider)
    {
        return new static($provider);
    }

    public function info($options = [])
    {
        return $this->provider->info($options);
    }

    public function parseRequestData(Request $request)
    {
        return $this->provider->parseRequestData($request);
    }

    public function getUserRedirectUrl($data = [])
    {
        return $this->provider->getUserRedirectUrl($data);
    }

    public function validated($request)
    {
        return $this->provider->validated($request);
    }

    public function resetSession($data = [])
    {
        return $this->provider->resetSession($data);
    }

    public function user($payload = [])
    {
        return $this->provider->user($payload);
    }
}
