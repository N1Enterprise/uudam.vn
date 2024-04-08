<?php

namespace App\Models;

class OauthPkce extends BaseModel
{
    protected $fillable = [
        'oauth_provider_code',
        'code_challenge',
        'code_verifier'
    ];
}
