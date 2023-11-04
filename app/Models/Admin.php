<?php

namespace App\Models;

use App\Casts\Hash;
use App\Enum\ActivationStatusEnum;
use App\Models\BaseAuthenticateModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;

class Admin extends BaseAuthenticateModel
{
    use HasFactory;
    use SoftDeletes;
    use HasRoles;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'password' => Hash::class,
    ];

    public function isActive()
    {
        return ! $this->trashed();
    }

    public function getStatusAttribute()
    {
        return $this->trashed() ? ActivationStatusEnum::INACTIVE : ActivationStatusEnum::ACTIVE;
    }

    public function getPermissionByPrefix($prefix, $pluckName = true)
    {
        $permissions = $this->getAllPermissions()->filter(function($permission) use ($prefix) {
            return Str::of($permission->name)->beforeLast('.')->exactly($prefix);
        });

        return $pluckName
            ? optional($permissions)->pluck('name')
            : $permissions;
    }

    public function getDisplayProperty()
    {
        return $this->name;
    }

    public function getLastLoginAtLocalizedAttribute()
    {
        return $this->last_login_at ? convert_datetime_to_client_time($this->last_login_at) : null;
    }
}
