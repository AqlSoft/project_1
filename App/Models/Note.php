<?php

namespace App\Models;


use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Messages\MailMessage;

class Note extends Notification
{
    use Queueable;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)  
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('You have a new order.')
            ->action('View Order', url('/orders', $this->order->id));
    }

    public function toDatabase($notifiable)
    {
        return ['order_id' => $this->order->id];
    }
}
