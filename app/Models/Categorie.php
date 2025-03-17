<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $table = 'categories'; // Spécifiez le nom de la table si ce n'est pas 'cantons' au pluriel
    protected $primaryKey = 'id'; // Spécifiez la clé primaire si ce n'est pas 'id'
    public $timestamps = true; // Indique si vous voulez les colonnes created_at et updated_at

    protected $fillable = [
        'nom', // Colonne que vous voulez pouvoir remplir massivement
        'display_name', // Colonne que vous voulez pouvoir remplir massivement
    ];

    /**
     * Get all of the services for the categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
