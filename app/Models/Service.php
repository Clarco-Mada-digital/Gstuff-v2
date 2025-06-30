<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasFactory, LogsActivity, HasTranslations;  

    
    protected $table = 'services'; // Spécifiez le nom de la table si ce n'est pas 'villes' au pluriel
    protected $primaryKey = 'id'; // Spécifiez la clé primaire si ce n'est pas 'id'
    public $timestamps = true; // Indique si vous voulez les colonnes created_at et updated_at

    protected $fillable = [
        'nom',
        'categorie_id', // Colonne de clé étrangère
    ];
    public $translatable = ['nom'];


    /**
     * Get the canton that owns the Ville
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    /**
     * The users that belong to the service.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_service', 'service_id', 'user_id');
    }
}
