<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LogsActivity;

    // Spécifiez les attributs à logger
    protected static $logAttributes = ['pseudo', 'email', 'prenom', 'nom_salon', 'nom_proprietaire', 'telephone', 'adresse'];

    // Ne logger que les champs modifiés
    protected static $logOnlyDirty = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_EDITOR = 'editor';
    const ROLE_WRITE = 'write';
    const ROLE_USER = 'user';

    protected $hiddenForActivities = [
        'password',
        'remember_token',
        'password_reset_token',
        'credit_card'
    ];

    protected $dates = [
        'last_seen_at',
        'created_at',
        'updated_at'
    ];

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
        'createbysalon',
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
        'visible_countries' => 'array',
        'createbysalon' => 'boolean', 
    ];

    public function getVisibleCountriesAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function setVisibleCountriesAttribute($value)
    {
        $this->attributes['visible_countries'] = json_encode($value);
    }

    public function isProfileVisibleTo($countryCode)
    {
        if ($this->visibility === 'public') {
            return true;
        }

        if ($this->visibility === 'private') {
            return false;
        }

        // Pour 'custom', vérifier les pays autorisés
        return in_array($countryCode, $this->visible_countries ?? []);
    }

    public function canton(): BelongsTo
    {
        return $this->belongsTo(Canton::class);
    }

    public function cantonget()
    {
        return $this->belongsTo(Canton::class, 'canton');
    }

    public function villeget()
    {
        return $this->belongsTo(Ville::class, 'ville');
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

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    // Relation avec les invitations envoyées
    public function invitations()
    {
        return $this->hasMany(Invitation::class, 'inviter_id');
    }

    // Relation avec les invitations reçues
    public function receivedInvitations()
    {
        return $this->hasMany(Invitation::class, 'invited_id');
    }

     // Relation avec detection de on line
     public function isOnline()
     {
         // Vérifie d'abord le cache
         if (Cache::has('user-is-online-' . $this->id)) {
             return true;
         }
         
         // Si pas dans le cache, vérifie si la dernière activité était récente (2 minutes par exemple)
         $user = User::find($this->id);
         $lastSeen = $user->last_seen_at instanceof \Carbon\Carbon 
             ? $user->last_seen_at 
             : Carbon::parse($user->last_seen_at);
         if ($this->last_seen_at) {
             return $lastSeen->gt(now()->subMinutes(2));
         }
         
         return false;
     } 

    public function getLastActivityAttribute()
    {
        return Cache::get('user-is-online-' . $this->id);
    }

    public function getLastSeenForHumansAttribute()
    {
        // verification si l'user est en ligne
        if ($this->isOnline()) {
            return 'En ligne';
        }

        // vérifier last_seen_at
        if (!$this->last_seen_at) {
            return 'Jamais connecté';
        }

        $lastSeen = Carbon::parse($this->last_seen_at);
        $diffInMinutes = now()->diffInMinutes($lastSeen);

        if ($diffInMinutes < 2) {
            return 'À l\'instant';
        } elseif ($diffInMinutes < 60) {
            return 'Il y a ' . $diffInMinutes . ' min';
        } elseif ($diffInMinutes < 1440) {
            return 'Il y a ' . now()->diffInHours($lastSeen) . ' h';
        } else {
            return 'Il y a ' . now()->diffInDays($lastSeen) . ' jours';
        }
    }

    /**
     * Les escortes associées à un salon.
     */
    public function escortes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'salon_escorte', 'salon_id', 'escorte_id');
    }

    /**
     * Les salons auxquels une escorte est associée.
     */
    public function salons(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'salon_escorte', 'escorte_id', 'salon_id');
    }

    

}
