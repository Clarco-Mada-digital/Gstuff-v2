<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    // Définir la table associée au modèle (optionnel si le nom est le même que celui de la table)
    protected $table = 'invitations';

    // Spécifiez les colonnes pouvant être remplies
    protected $fillable = [
        'inviter_id',
        'invited_id',
        'accepted',
    ];

    /**
     * Relation avec l'utilisateur qui a envoyé l'invitation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inviter()
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    /**
     * Relation avec l'utilisateur qui a reçu l'invitation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invited()
    {
        return $this->belongsTo(User::class, 'invited_id');
    }
}
