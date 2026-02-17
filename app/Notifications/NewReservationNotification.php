<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewReservationNotification extends Notification
{
    use Queueable;

    public $reservation;

    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'client_name' => $this->reservation->user->name,
            'restaurant_name' => $this->reservation->restaurant->nom,
            'date' => $this->reservation->date,
            'time' => $this->reservation->time,
            'guests' => $this->reservation->guests,
            'payment_status' => $this->reservation->payment_status,
        ];
    }
}

