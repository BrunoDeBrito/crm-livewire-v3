<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * @class ValidationCodeNotification
 * @author BrunoDeBrito @email <brunordebrito@gmail.com>
 * @since 8/12/26 15:52
 * @version 1.0.0
 *
 */
class ValidationCodeNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->line('Thank you for using our application!')
            ->line('Your validation code is: ' . $notifiable->validation_code)
            ->line($notifiable->validation_code);
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
