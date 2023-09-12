<?php

namespace App\Models;

use App\Casts\Hash;
use App\Models\Traits\Activatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Activatable;
    use SoftDeletes;
    use Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'status',
        'last_logged_in_at',
        'phone_number',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'password' => Hash::class,
    ];
}
