<?php

namespace App\Http\Middleware;

use App\Classes\Contracts\UserAuthContract;
use App\Enum\SystemSettingKeyEnum;
use App\Models\SystemSetting;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class FrontendMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var UserAuthContract */
        $userAuth = app(UserAuthContract::class);
        $user = $userAuth->user();

        $route = Route::getRoutes()->match($request);

        if ($user instanceof User) {
            $requiredOauthUserCompleteInformationBeforeSignin = SystemSetting::from(SystemSettingKeyEnum::REQUIRED_OAUTH_USER_COMPLETE_INFORMATION_BEFORE_SIGNIN)->get(null, false);

            if ($route->getName() == 'fe.web.user.complete-infomation') {
                if ($this->isUserCompletedProfile($user)) {
                    return redirect()->route('fe.web.home');
                }

                return $next($request);
            }

            if ($requiredOauthUserCompleteInformationBeforeSignin && ! $this->isUserCompletedProfile($user)) {
                return redirect()->route('fe.web.user.complete-infomation');
            }
        }

        return $next($request);
    }

    public function isUserCompletedProfile(User $user)
    {
        return !empty($user->phone_number);
    }
}
