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
use App\Models\CouleurYeux;
use App\Models\Genre;
use App\Models\Mensuration;
use App\Models\OrientationSexuelle;
use App\Models\PratiqueSexuelle;
use App\Models\Poitrine;
use App\Models\Silhouette;
use App\Models\PubisType;
use App\Models\Tatoo;
use Spatie\Translatable\HasTranslations;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LogsActivity, HasTranslations;

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

    /**
     * Get the profile associated with the user.
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }


    /**
     * Get the ville associated with the user.
     */
    public function ville(): BelongsTo
    {
        return $this->belongsTo(Ville::class, 'ville', 'id');
    }
    
    /**
     * Get the ville relation with proper casting for PostgreSQL
     */
    public function villeRelation()
    {
        return $this->belongsTo(Ville::class, 'ville', 'id');
    }
    
    /**
     * Get the canton relation with proper casting for PostgreSQL
     */
    public function cantonRelation()
    {
        return $this->belongsTo(Canton::class, 'canton', 'id');
    }
    
    /**
     * Get the categorie relation with proper casting for PostgreSQL
     */
    public function categorieRelation()
    {
        return $this->belongsTo(Categorie::class, 'categorie', 'id');
    }

    /**
     * Get the categories associated with the user.
     */
  

    /**
     * Get the services associated with the user.
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'user_service', 'user_id', 'service_id');
    }

    protected $fillable = [
        'avatar',
        'couverture_image',
        'pseudo',
        'prenom',
        'date_naissance',
        'genre_id',
        'nom_salon',
        'intitule',
        'nom_proprietaire',
        'email',
        'password',
        'profile_type',
        'email_verified_at',
        'password_reset_token',
        'password_reset_expiry',
        'telephone',
        'adresse',
        'npa',
        'canton',
        'ville',
        'langues',
        'categorie',
        'service',
        'recrutement',
        'nombre_fille_id',
        'pratique_sexuelle_id',
        'tailles',
        'origine',
        'couleur_yeux_id',
        'orientation_sexuelle_id',
        'couleur_cheveux_id',
        'mensuration_id',
        'poitrine_id',
        'silhouette_id',
        'taille_poitrine',
        'tatoo_id',
        'mobilite_id',
        'pubis_type_id',
        'tarif',
        'paiement',
        'apropos',
        'autre_contact',
        'complement_adresse',
        'lien_site_web',
        'localisation',
        'lat',
        'lon',
        'profile_verifie',
        'image_verification',
        'createbysalon',
        'canton',
        'ville',
        'categorie',
        'is_profil_pause',
    ];

    public $translatable = ['apropos'];

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
        'date_naissance' => 'date',
        'password_reset_expiry' => 'datetime',
        'categorie' => 'array',
        'service' => 'array',
        'paiement' => 'array',
        'langues' => 'array',
        'profile_verifie' => 'string',
        'visible_countries' => 'array',
        'createbysalon' => 'boolean',
        'is_profil_pause' => 'boolean', 
    ];

    public function getVisibleCountriesAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function setVisibleCountriesAttribute($value)
    {
        $this->attributes['visible_countries'] = json_encode($value);
    }


    public function getCategoriesAttribute()
    {
        $category = $this->categorie;

        if (is_integer($category)) {
            $categorie = Categorie::find($category);
            return $categorie ? collect([$categorie]) : collect();
        }

        
        // Si c'est déjà un modèle Categorie, on le retourne dans une collection
        if ($category instanceof \App\Models\Categorie) {
            return collect([$category]);
        }
        
        // Si c'est une chaîne de caractères
        if (is_string($category)) {
            
                $categorie = Categorie::find($category);
                return $categorie ? collect([$categorie]) : collect();
         
        }
        
        // Si c'est un tableau avec un ID, on cherche la catégorie correspondante
        if (is_array($category) && isset($category['id'])) {
          
            $categorie = Categorie::find($category['id']);
            return $categorie ? collect([$categorie]) : collect();
        }
        
        // Si c'est un tableau d'IDs
        if (is_array($category)) {
            $categoryIds = array_filter($category, function($item) {
                return is_numeric($item) || (is_array($item) && isset($item['id']));
            });
            
            if (!empty($categoryIds)) {
                // Si c'est un tableau de tableaux avec des clés 'id'
                if (is_array(reset($categoryIds)) && isset(reset($categoryIds)['id'])) {
                    $categoryIds = array_column($categoryIds, 'id');
                }
                return Categorie::whereIn('id', $categoryIds)->get();
            }
        }
        
        // Par défaut, retourner une collection vide
        return collect();
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
        // Check if user is online
        if ($this->isOnline()) {
            return __('user.online');
        }

        // Check last_seen_at
        if (!$this->last_seen_at) {
            return __('user.never_connected');
        }

        $lastSeen = Carbon::parse($this->last_seen_at);
        $diffInMinutes = now()->diffInMinutes($lastSeen);

        if ($diffInMinutes < 2) {
            return __('user.just_now');
        } elseif ($diffInMinutes < 60) {
            return __('user.minutes_ago', ['count' => $diffInMinutes]);
        } elseif ($diffInMinutes < 1440) {
            return __('user.hours_ago', ['count' => now()->diffInHours($lastSeen)]);
        } else {
            return __('user.days_ago', ['count' => now()->diffInDays($lastSeen)]);
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

    /**
     * Get the couleur_yeux associated with the user.
     */
    public function couleurYeux()
    {
        return $this->belongsTo(CouleurYeux::class, 'couleur_yeux_id');
    }

    /**
     * Get the genre associated with the user.
     */
    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }

    /**
     * Get the orientation sexuelle associated with the user.
     */
    public function orientationSexuelle()
    {
        return $this->belongsTo(OrientationSexuelle::class, 'orientation_sexuelle_id');
    }

    /**
     * Get the pratique sexuelle associated with the user.
     */
    public function pratiqueSexuelle()
    {
        return $this->belongsTo(PratiqueSexuelle::class, 'pratique_sexuelle_id');
    }

    /**
     * Get the couleur cheveux associated with the user.
     */
    public function couleurCheveux()
    {
        return $this->belongsTo(CouleurCheveux::class, 'couleur_cheveux_id');
    }

    /**
     * Get the mensuration associated with the user.
     */
    public function mensuration()
    {
        return $this->belongsTo(Mensuration::class, 'mensuration_id');
    }

    /**
     * Get the poitrine associated with the user.
     */
    public function poitrine()
    {
        return $this->belongsTo(Poitrine::class, 'poitrine_id');
    }

    /**
     * Get the silhouette associated with the user.
     */
    public function silhouette()
    {
        return $this->belongsTo(Silhouette::class, 'silhouette_id');
    }

    public function tatoo()
    {
        return $this->belongsTo(Tatoo::class, 'tatoo_id');
    }

    public function mobilite()
    {
        return $this->belongsTo(Mobilite::class, 'mobilite_id');
    }

    public function nombreFille()
    {
        return $this->belongsTo(NombreFille::class, 'nombre_fille_id');
    }

    public function pubisType()
    {
        return $this->belongsTo(PubisType::class,'pubis_type_id');
    }

    /**
     * Get the stories for the user.
     */
    public function stories()
    {
        return $this->hasMany(\App\Models\Story::class);
    }
}
