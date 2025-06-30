<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ville extends Model
{
    use HasFactory;

    protected $table = 'villes'; // Spécifiez le nom de la table si ce n'est pas 'villes' au pluriel
    protected $primaryKey = 'id'; // Spécifiez la clé primaire si ce n'est pas 'id'
    public $timestamps = true; // Indique si vous voulez les colonnes created_at et updated_at

    protected $fillable = [
        'nom',
        'canton_id', // Colonne de clé étrangère
    ];

    /**
     * Get the canton that owns the Ville
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function canton(): BelongsTo
    {
        return $this->belongsTo(Canton::class);
    }
}
