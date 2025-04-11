<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Commentaire;

class NewCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $commentaire;

    /**
     * Crée une nouvelle instance de notification.
     *
     * @param Commentaire $commentaire
     */
    public function __construct(Commentaire $commentaire)
    {
        $this->commentaire = $commentaire; // Correction : utiliser $commentaire au lieu de $user
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
            ->subject('Nouveau commentaire posté')
            ->greeting('Bonjour Admin,')
            ->line('Un nouvel utilisateur a posté un commentaire.')
            ->action('Voir le commentaire', url('/admin/commentaires'))
            ->line('Merci de vérifier et d’approuver si nécessaire.');
    }

    /**
     * Notification en base de données.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Nouveau commentaire ajouté',
            'message' => 'L\'utilisateur ' . $this->commentaire->user->name . ' a posté un commentaire.',
            'url' => '/commentaires',
            'user_id' => $this->commentaire->user->id,
            'comment_id' => $this->commentaire->id,
        ];
    }
}
