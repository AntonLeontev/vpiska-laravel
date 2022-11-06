<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends ResetPassword
{
    use Queueable;

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Уведомление о сбросе пароля - '  . config('app.name'))
            ->line('Вы получили это письмо, потому что кто-то запросил сброс пароля для вашей учетной записи.')
            ->action('Сменить пароль', url(route('password.reset', $this->token)))
            ->line('Если вы не запрашивали сброс пароля, никаких дальнейших действий не требуется.');
    }
}
