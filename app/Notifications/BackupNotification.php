<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BackupNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $status;
    protected $message;
    protected $details;

    /**
     * Create a new notification instance.
     */
    public function __construct($status, $message, $details = null)
    {
        $this->status = $status;
        $this->message = $message;
        $this->details = $details;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $subject = $this->status === 'success' 
            ? '✅ Sauvegarde réussie' 
            : '❌ Échec de la sauvegarde';

        $mail = (new MailMessage)
                    ->subject(env('APP_NAME') . ' - ' . $subject)
                    ->line($this->message);

        if ($this->details) {
            $mail->line('Détails:')
                 ->line($this->details)
                 ->line('')
                 ->line('Date: ' . now()->format('Y-m-d H:i:s'));
        }

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'details' => $this->details,
        ];
    }
}
