<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject(Lang::get('Подтверждение почты'))
            ->line(Lang::get('Нажмите кнопку, чтобы подтвердить почту.'))
            ->action(Lang::get('Подтвердить почту'), $url)
            ->line(Lang::get('Если вы не регистрировались, то не обращайте внимания на это письмо.'));
    }
}
