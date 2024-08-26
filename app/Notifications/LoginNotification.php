<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginNotification extends Notification
{
    use Queueable;

    public $message;
    public $subject;
    public $fromEmail;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->message = "You just logged in";
        $this->subject = "New Login Notification";
        $this->fromEmail = "mayarmohamedhamed12345@gmail.com";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from($this->fromEmail)
            ->subject($this->subject)
            ->greeting('Hello Dear,')
            ->line($this->message);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
