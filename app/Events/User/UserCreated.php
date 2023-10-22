<?php

namespace App\Events\User;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserCreated
{
    use SerializesModels;
    use Dispatchable;

    public $user;
    public $attributes;
    public $userEmailVerificationLink;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $attributes = [], $userEmailVerificationLink = null)
    {
        $this->user = $user;
        $this->attributes = $attributes;
        $this->userEmailVerificationLink = $userEmailVerificationLink;
    }
}
