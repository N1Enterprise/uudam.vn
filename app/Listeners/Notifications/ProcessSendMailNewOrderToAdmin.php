<?php

namespace App\Listeners\Notifications;

use App\Enum\SystemSettingKeyEnum;
use App\Events\Order\OrderCreated;
use App\Models\Admin;
use App\Models\SystemSetting;
use App\Notifications\SendNewOrderToAdmin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Arr;
use App\Models\Order;

class ProcessSendMailNewOrderToAdmin implements ShouldQueue
{
    public $timeout = 300;

    public $tries = 30;

    public $backoff = 5;

    public $afterCommit = true;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $receivers = Arr::wrap(SystemSetting::from(SystemSettingKeyEnum::ENABLE_SEND_MAIL_WHEN_USER_ORDERED)->get('receivers', []) ?? []);

        /** @var Order */
        $order = $event->order;

        Admin::query()
            ->where('email', $receivers)
            ->each(function(Admin $admin) use ($order) {
                $admin->notify(new SendNewOrderToAdmin($admin, $order));
            });
    }

    public function shouldQueue()
    {
        $enableSendMail = SystemSetting::from(SystemSettingKeyEnum::ENABLE_SEND_MAIL_WHEN_USER_ORDERED)->get('enable');
        $receivers = Arr::wrap(SystemSetting::from(SystemSettingKeyEnum::ENABLE_SEND_MAIL_WHEN_USER_ORDERED)->get('receivers', []));

        return boolean($enableSendMail) && !empty($receivers);
    }
}
