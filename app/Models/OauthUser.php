<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OauthUser extends Model
{
    protected $fillable = [
        'user_id',
        'provider_user_id',
        'provider',
        'meta',
    ];

    protected $casts = [
        'meta' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
