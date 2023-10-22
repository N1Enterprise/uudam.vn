<?php

namespace App\Events\User;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SystemSettingUpdated
{
    use SerializesModels;
    use Dispatchable;

    public $setting;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($setting)
    {
        $this->setting = $setting;
    }
}
