<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNewOrderToAdmin extends Notification
{
    use Queueable;
    use Dispatchable;
    use InteractsWithQueue;
    use SerializesModels;

    public $tries = 3;

    public $url;

    public $admin;

    public $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($admin, $order)
    {
        $this->admin = $admin;
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('[uudam.vn] Có đơn hàng mới #' . data_get($this->order, 'order_code'). ' vào lúc '. format_datetime(data_get($this->order, 'created_at'), 'd/m/Y H:i'))
            ->markdown('frontend.mail.admin.new-order', [
                'admin_name'    => data_get($this->admin, 'name'),
                'url'           => route('bo.web.orders.edit', data_get($this->order, 'id')),
                'order_code'    => data_get($this->order, 'order_code'),
                'user_fullname' => data_get($this->order, 'fullname'),
                'user_email'    => data_get($this->order, 'email'),
                'user_phone'    => data_get($this->order, 'phone'),
                'order_at'      => format_datetime(data_get($this->order, 'created_at'), 'd/m/Y H:i'),
                'grand_total'   => format_price(data_get($this->order, 'grand_total')),
            ]);
    }
}
