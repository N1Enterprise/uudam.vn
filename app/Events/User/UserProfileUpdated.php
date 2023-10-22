<?php

namespace App\Events\User;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserProfileUpdated
{
    use SerializesModels;
    use Dispatchable;

    public $user;
    public $userDetail;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $userDetail = null)
    {
        $this->user = $user;
        $this->userDetail = $userDetail;
    }
}
