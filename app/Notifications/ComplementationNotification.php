<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ComplementationNotification extends Notification
{
    use Queueable;

    public $percentCompletions;
    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($percent)
    {
        $this->percentCompletions = $percent;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase($notifiable)
    {
        if ($this->percentCompletions < 100) {
            $this->message = "Vous avez complété votre profil à " . $this->percentCompletions . "%. Pour mieux profiter de nos services, c'est mieux de compléter votre profile au mieux que possible.";
        }else{
            $this->message = "Félicitation! Vous avez complété votre profil à 100%. Vous pouvez maintenant profiter pleinement de nos services.";
        }

        return [
            'title' => 'Profil completé à ' . $this->percentCompletions . '%',
            'message' => $this->message,
            'url' => '/profile',
        ];
    }
}
