<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendUserResetPassword extends Notification
{
    use Queueable;
    use Dispatchable;
    use InteractsWithQueue;
    use SerializesModels;

    public $tries = 3;

    public $url;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $url)
    {
        $this->url = $url;
        $this->user = $user;
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
            ->subject('UUDAM.VN - Cập nhật mật khẩu tài khoản')
            ->markdown('frontend.mail.user.password-reset', [
                'url'  => $this->url,
                'user' => optional($this->user)->name
            ]);
    }
}
