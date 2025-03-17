<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services'; // Spécifiez le nom de la table si ce n'est pas 'villes' au pluriel
    protected $primaryKey = 'id'; // Spécifiez la clé primaire si ce n'est pas 'id'
    public $timestamps = true; // Indique si vous voulez les colonnes created_at et updated_at

    protected $fillable = [
        'nom',
        'categorie_id', // Colonne de clé étrangère
    ];

    /**
     * Get the canton that owns the Ville
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }
}
