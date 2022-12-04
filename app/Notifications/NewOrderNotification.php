<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewOrderNotification extends Notification implements ShouldBroadcast, ShouldQueue
{
    use Queueable;


    public function __construct()
    {
    }

    public function via($notifiable)
    {
        return ['mail', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)->view('mails.orders.newToCreator')->subject('Новый заказ');
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => 'Новый заказ на ваше мероприятие',
            'notifications' => $notifiable->notifications,
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Новый заказ на ваше мероприятие',
            'number' => $notifiable->notifications,
        ];
    }
}
