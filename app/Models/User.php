<?php

    namespace App\Models;

    // use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Sanctum\HasApiTokens;
    use Spatie\Permission\Traits\HasRoles;

    class User extends Authenticatable
    {
        use HasApiTokens, HasFactory, Notifiable, HasRoles;

        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        const ROLE_ADMIN = 'admin';
        const ROLE_EDITOR = 'editor';
        const ROLE_WRITE = 'write';
        const ROLE_USER = 'user';

        protected $fillable = [
            'avatar',
            'couverture_image',
            'pseudo',
            'prenom',
            'date_naissance',
            'genre',
            'nom_salon',
            'intitule',
            'nom_proprietaire',
            'email',
            'password',
            'profile_type',
            'email_verified_at',
            'password_reset_token',
            'password_reset_expiry',
            'telephone', // Ajoutez ici les nouveaux champs
            'adresse',
            'npa',
            'canton',
            'ville',
            'langues',
            'categorie',
            'service',
            'oriantation_sexuelles',
            'recrutement',
            'nombre_filles',
            'pratique_sexuelles',
            'tailles',
            'origine',
            'couleur_yeux',
            'couleur_cheveux',
            'mensuration',
            'poitrine',
            'taille_poitrine',
            'pubis',
            'tatouages',
            'mobilite',
            'tarif',
            'paiement',
            'apropos',
            'autre_contact',
            'complement_adresse',
            'lien_site_web',
            'localisation',
            'lat',
            'lon',
            'profile_verifie', // Ajout du nouveau champ
            'image_verification',
        ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'password_reset_token', // Cacher le token de réinitialisation aussi
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
      'email_verified_at' => 'datetime',
      'date_naissance' => 'date', // Cast date_naissance en tant que date
      'password_reset_expiry' => 'datetime', // Cast password_reset_expiry en tant que datetime
      'categorie' => 'array',
      'service' => 'array',
    //   'canton' => 'array',
    //   'ville' => 'array',
      'paiement' => 'array',
      'langues' => 'array',
      'profile_verifie' => 'string',
  ];

  public function canton(): BelongsTo
  {
      return $this->belongsTo(Canton::class);
  }

   // Relation avec les utilisateurs favoris
   public function favorites()
   {
       return $this->belongsToMany(User::class, 'favorites', 'user_id', 'favorite_user_id');
   }

   // Relation pour récupérer les utilisateurs qui ont ajouté un utilisateur dans leurs favoris
   public function favoritedBy()
   {
       return $this->belongsToMany(User::class, 'favorites', 'favorite_user_id', 'user_id');
   }
   public function commentaires()
{
    return $this->hasMany(Commentaire::class);
}

}

