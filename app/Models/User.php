<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Casts\Hash;
use App\Common\RequestHelper;
use App\Enum\AccessChannelType;
use App\Enum\SystemSettingKeyEnum;
use App\Enum\UserStatusEnum;
use App\Models\Traits\Activatable;
use App\Models\Traits\HasCurrency;
use App\Models\Traits\HasImpactor;
use App\Notifications\SendUserResetPassword;
use Carbon\Carbon;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\URL;

class User extends BaseAuthenticateModel implements MustVerifyEmail
{
    use Activatable;
    use SoftDeletes;
    use Notifiable;
    use HasCurrency;
    use CanResetPassword;
    use HasImpactor;

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'status',
        'currency_code',
        'last_logged_in_at',
        'is_test_user',
        'phone_number',
        'birthday',
        'email_verified_at',
        'access_channel_type',
        'meta',
        'created_by_id',
        'created_by_type',
        'updated_by_id',
        'updated_by_type',
        'allow_login'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'password' => Hash::class,
        'meta' => 'json'
    ];

    public function sendPasswordResetNotification($token)
    {
        $link = parse_expression(
            SystemSetting::from(SystemSettingKeyEnum::USER_FE_RESET_PASSWORD_LINK)->get(),
            [
                'fe_host' => RequestHelper::getClientDomain(request()) ?? config('user.host'),
                'token' => urlencode($token),
                'email' => urlencode($this->getEmailForPasswordReset()),
            ]
        );

        return $this->notify(new SendUserResetPassword($this, $link));
    }

    public function generateEmailVerificationUrl($verificationUrl = null)
    {
        $link = URL::temporarySignedRoute(
            'fe.api.user.email_verification.verify',
            now()->addMinutes(config('user.email_verification_expire', 60)),
            [
                'id' => $this->getKey(),
                'hash' => sha1($this->getEmailForVerification()),
            ]
        );

        if ($verificationUrl === null) {
            return rtrim(config('user.host'), '/').'/verify-email?'. Arr::query([
                'link' => $link,
            ]);
        }

        return rtrim($verificationUrl).'?'.Arr::query([
            'link' => $link,
        ]);
    }

    public function getSerializedStatusAttribute()
    {
        $status = UserStatusEnum::ACTIVE;

        if (! $this->isActive()) {
            $status = UserStatusEnum::INACTIVE;
        }

        return $status;
    }

    public function getAccessChannelTypeNameAttribute()
    {
        return AccessChannelType::findConstantLabel($this->access_channel_type);
    }

    public function getSerializedStatusNameAttribute()
    {
        return UserStatusEnum::findConstantLabel($this->serialized_status);
    }

    public function setLoggedInAt(Carbon $time = null)
    {
        $this->update(['last_logged_in_at' => $time]);

        return $this;
    }

    public function userWallets()
    {
        return $this->hasMany(UserWallet::class);
    }
}
