<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Common\RequestHelper;
use App\Contracts\Requests\Frontend\UserOauthSigninRequestContract;
use App\Enum\SystemSettingKeyEnum;
use App\Exceptions\BusinessLogicException;
use App\Http\Middleware\UserMiddleware;
use App\Models\SystemSetting;
use App\Services\OauthService;
use App\Services\OauthUserService;
use App\Services\UserAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class OauthController extends BaseApiController
{
    public $oauthUserService;
    public $userAuthService;

    public function __construct(OauthUserService $oauthUserService, UserAuthService $userAuthService)
    {
        parent::__construct();

        $this->oauthUserService = $oauthUserService;
        $this->userAuthService = $userAuthService;
    }

    public function providers(Request $request)
    {
        $oauthProviders = collect(SystemSetting::from(SystemSettingKeyEnum::SUPPORTED_OAUTH_PROVIDERS)->values())
            ->where('enable', true)
            ->map(function($info, $provider) use ($request) {
                return OauthService::of($provider)->info([
                    'redirect_params' => [
                        'host' => RequestHelper::getClientDomain($request),
                        'path' => $request->get('path', $request->path)
                    ]
                ]);
            })
            ->filter()
            ->values();

        return response()->json(['oauth_providers' => $oauthProviders]);
    }

    public function callback(Request $request, $provider)
    {
        $oauthProvider = OauthService::of($provider);

        $data = $oauthProvider->parseRequestData($request);

        return redirect(
            $oauthProvider->getUserRedirectUrl($data)
        );
    }

    public function signin(UserOauthSigninRequestContract $request)
    {
        $provider = $request->get('provider');

        if (! $provider) {
            throw ValidationException::withMessages(['provider' => __('validation.required', ['attribute' => 'provider'])]);
        }

        try {
            $providerInstance = OauthService::of($provider);

            $data = $providerInstance->validated($request);

            $oauthUser = OauthService::of($provider)->user($data);

            $user = $this->oauthUserService->findOrCreate($provider, $oauthUser, $request->validated());

            $requiredOauthUserCompleteInformationBeforeSignin = SystemSetting::from(SystemSettingKeyEnum::REQUIRED_OAUTH_USER_COMPLETE_INFORMATION_BEFORE_SIGNIN)->get(null, false);

            if ($requiredOauthUserCompleteInformationBeforeSignin && empty($user->phone_number)) {
                $oauthProvider = OauthService::of($provider);

                return redirect($oauthProvider->getUserRedirectUrl(array_merge($data, ['required_oauth_user_complete_information_before_signin' => 1])));
            }

            $user = $this->userAuthService->signinByUser($user);

            pipeline()
                ->send($request)
                ->through(UserMiddleware::class)
                ->thenReturn();

            return response()->json($user->only(['username']));
        } catch (\Throwable $th) {
            Log::error('Got error when signin user by oauth provider with message: '.$th->getMessage(), [
                'provider' => $provider,
                'trace' => $th->getTraceAsString(),
            ]);

            throw new BusinessLogicException($th->getMessage());
        }
    }
}
