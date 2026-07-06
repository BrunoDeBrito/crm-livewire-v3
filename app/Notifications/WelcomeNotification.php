<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * @class WelcomeNotification
 * @author BrunoDeBrito <brunordebrito@gmail.com>
 * @since 6/18/26 23:00
 * @version 1.0.0
 *
 */
class WelcomeNotification extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->line('Welcome to our CRM! Happy to see you here.')
            ->line('Thank you for using our application!');
    }
}
