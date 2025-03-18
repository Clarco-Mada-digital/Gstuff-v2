<?php

    namespace App\Models;

    // use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Sanctum\HasApiTokens;

    class User extends Authenticatable
    {
        use HasApiTokens, HasFactory, Notifiable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $fillable = [
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
  ];

  public function canton(): BelongsTo
  {
      return $this->belongsTo(Canton::class);
  }
}

