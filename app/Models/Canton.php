<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Canton extends Model
{
    use HasFactory;

    protected $table = 'cantons'; // Spécifiez le nom de la table si ce n'est pas 'cantons' au pluriel
    protected $primaryKey = 'id'; // Spécifiez la clé primaire si ce n'est pas 'id'
    public $timestamps = true; // Indique si vous voulez les colonnes created_at et updated_at

    protected $fillable = [
        'nom', // Colonne que vous voulez pouvoir remplir massivement
    ];

    /**
     * Get all of the villes for the Canton
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function villes(): HasMany
    {
        return $this->hasMany(Ville::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'canton', 'id');
    }
}
