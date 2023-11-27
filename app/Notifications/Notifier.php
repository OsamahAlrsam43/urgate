<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Notifiable;

class Notifier extends Notification
{
    use Queueable;

    public $data;
    public $subject;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data, $subject)
    {
        $this->data = $data;
        $this->subject = $subject;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [ 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //return (new MailMessage)->subject($this->subject)->view('emails.notification', ['msg' => array_merge($this->data, ['title' => 'Account Transactions'])]);
    }

    public function toDatabase($notifiable)
    {
        return [
            'user_id' => $notifiable->id,
            'data' => $this->data,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'user_id' => $notifiable->id,
            'data' => $this->data,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user_id' => $notifiable->id,
            'data' => $this->data,
        ];
    }
}
