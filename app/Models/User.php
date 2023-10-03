<?php

namespace App\Models;

use App\Casts\Hash;
use App\Models\Traits\Activatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\URL;

class User extends Authenticatable
{
    use Activatable;
    use SoftDeletes;
    use Notifiable;

    protected $fillable = [
        'email',
        'phone_number',
        'status',
        'password',
        'last_logged_in_at',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'password' => Hash::class,
    ];

    // public function userDetail()
    // {
    //     return $this->hasOne(UserDetail::class);
    // }

    public function generateEmailVerificationUrl($verificationUrl = null)
    {
        $link = URL::temporarySignedRoute(
            'fe.user.web.email_verification.verify',
            now()->addMinutes(config('frontend.email_verification_expire', 60)),
            [
                'id' => $this->getKey(),
                'hash' => sha1($this->getEmailForVerification()),
            ]
        );

        if ($verificationUrl === null) {
            return rtrim(config('frontend.host'), '/').'/verify-email?'. Arr::query([
                'link' => $link,
            ]);
        }

        return rtrim($verificationUrl).'?'.Arr::query([
            'link' => $link,
        ]);
    }

    public function setLoggedInAt(Carbon $time = null)
    {
        $this->update(['last_logged_in_at' => $time]);

        return $this;
    }
}
