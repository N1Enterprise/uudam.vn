<?php

namespace App\Events\User;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserPasswordChanged
{
    use SerializesModels;
    use Dispatchable;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
}
