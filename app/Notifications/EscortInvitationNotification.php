<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EscortInvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $inviter;

    /**
     * Crée une nouvelle instance de notification.
     *
     * @param User $inviter
     */
    public function __construct($inviter)
    {
        $this->inviter = $inviter;
    }

    /**
     * Définir les canaux de notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database']; // Notification par email et base de données
    }

    /**
     * Notification par email.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Invitation reçue')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Vous avez été invité par ' . $this->inviter->name . '.')
            ->action('Voir l\'invitation', url('/profile'))
            ->line('Merci de vérifier et de répondre.');
    }

    /**
     * Notification en base de données.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        $name = $this->inviter->prenom ?? $this->inviter->nom_salon ?? $this->inviter->pseudo;
        return [
            'title' => 'Nouvelle invitation',
            'message' => 'Vous avez été invité par ' . $name . '.',
            'url' => '/notifications/markAsRead/' . $this->inviter->id,
            'inviter_id' => $this->inviter->id,
            'type' => 'escortInvitation',
            'inviter_name' => $name,
            'percent' => 0,
        ];
    }
}
