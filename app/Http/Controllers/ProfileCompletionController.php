<?php

namespace App\Http\Controllers;

use App\Models\Canton; // Assuming you have a Canton model
use App\Models\Ville;   // Assuming you have a Ville model
use App\Models\Categorie;   // Assuming you have a Categorie model
use App\Models\Favorite;
use App\Models\Message;
use App\Models\Service;
use App\Models\User;
use App\Notifications\ComplementationNotification;
use App\Notifications\ProfileVerificationRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Commentaire;
use App\Models\Invitation;
use App\Models\Genre;
use App\Models\PratiqueSexuelle;
use App\Models\OrientationSexuelle;
use App\Models\CouleurYeux;
use App\Models\CouleurCheveux;
use App\Models\Mensuration;
use App\Models\Poitrine;
use App\Models\Silhouette;
use App\Models\PubisType;
use App\Models\Tattoo;
use App\Models\Mobilite;
use App\Models\NombreFille;
use App\Services\DeepLTranslateService;
use App\Helpers\Locales;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ProfileCompletionController extends Controller
{


    

    protected $translateService;

    public function __construct(DeepLTranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if($user->canton){
            $user['canton'] = Canton::where('id', $user->canton)->first() ?? '';
            }
            if($user->ville){
            $user['ville'] = Ville::where('id', $user->ville)->first() ?? '';
            }
            $userCategorieIds = !empty($user->categorie) ? explode(',', $user->categorie) : [];
            $user['categorie'] = Categorie::whereIn('id', $userCategorieIds)->get();
            // dd($user->categorie);

            $serviceIds = !empty($user->service) ? explode(',', $user->service) : [];
            $user['services'] = Service::whereIn('id', $serviceIds)->get();

            // $user['service'] = $userService;

            // Les escortes
            $escorts = User::where('profile_type', 'escorte')->get();
            foreach ($escorts as $escort) {
                if($escort->canton){
                $escort['canton'] = Canton::where('id', $escort->canton)->first() ?? '';
                }
                if($escort->ville){
                $escort['ville'] = Ville::where('id', $escort->ville)->first() ?? '';
                }
                $categoriesIds = !empty($escort->categorie) ? explode(',', $escort->categorie) : [];
                $escort['categorie'] = Categorie::whereIn('id', $categoriesIds)->get();
                $serviceIds = !empty($escort->service) ? explode(',', $escort->service) : [];
                $escort['services'] = Service::whereIn('id', $serviceIds)->get();
                
                // dd($escort->service);
            }
            $cantons = Canton::all(); // Example: Fetch all cantons
            $villes = Ville::all();   // Example: Fetch all villes

            // You might need to fetch other dropdown data similarly
            $escort_categories = Categorie::where('type', 'escort')->get();
            $salon_categories = Categorie::where('type', 'salon')->get();
            $services = Service::all();
            $genres = Genre::all();
            $pratiquesSexuelles = PratiqueSexuelle::all();
            $oriantationSexuelles = OrientationSexuelle::all();
            $origines = ['Africaine', 'Allemande', 'Asiatique', 'Brésilienne', 'Caucasienne', 'Espagnole', 'Européene', 'Française', 'Indienne', 'Italienne', 'Latine', 'Métisse', 'Orientale', 'Russe', 'Suisesse'];
            $couleursYeux =CouleurYeux::all();
            $couleursCheveux =CouleurCheveux::all();
            $mensurations =Mensuration::all();
            $poitrines =Poitrine::all();
            $taillesPoitrine =['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
            $silhouette =Silhouette::all();
            $pubis =PubisType::all();
            $tatouages =Tattoo::all();
            $mobilites =Mobilite::all();
            $paiements = ['CHF', 'Euros', 'Dollars', 'Twint', 'Visa', 'Mastercard', 'American Express', 'Maestro', 'Postfinance', 'Bitcoin'];
            $nombreFilles =NombreFille::all();
            $langues = ['Allemand', 'Anglais', 'Arabe', 'Espagnol', 'Français', 'Italien', 'Portugais', 'Russe', 'Autre'];
            $tarifs = [100, 150, 200, 250, 300, 350, 400, 450, 500, 550, 600, 650, 700, 750, 800];

            // Récupérer les favoris de l'utilisateur
            $favoriteList = Favorite::with('user:id,pseudo,prenom,nom_salon,avatar')->where('user_id', Auth::user()->id)->get();

            // Récupérer les favoris de type "escort"
            $escortFavorites = $user->favorites()->where('profile_type', 'escorte')->get();
            foreach ($escortFavorites as $escort) {
                if($escort->canton){
                $escort['canton'] = Canton::where('id', $escort->canton)->first() ?? '';
                }
                if($escort->ville){
                $escort['ville'] = Ville::where('id', $escort->ville)->first() ?? '';
                }
                $escort['categorie'] = Categorie::find($escort->categorie);
                $serviceIds = !empty($escort->service) ? explode(',', $escort->service) : [];
                $escort['service'] = Service::whereIn('id', $serviceIds)->get();
                // dd($escort->service);
            }
            // Récupérer les favoris de type "salon"
            $salonFavorites = $user->favorites()->where('profile_type', 'salon')->get();
            foreach ($salonFavorites as $salon) {
                if($salon->canton){
                $salon['canton'] = Canton::where('id', $salon->canton)->first() ?? '';
                }
                if($salon->ville){
                $salon['ville'] = Ville::where('id', $salon->ville)->first() ?? '';
                }
                $salon['categorie'] = Categorie::find($salon->categorie);
                $serviceIds = !empty($salon->service) ? explode(',', $salon->service) : [];
                $salon['service'] = Service::whereIn('id', $serviceIds)->get();
                // dd($salon->service);
            }

            $commentairesCount = Commentaire::where('is_approved', false)->count();

            
            $messageNoSeen = Message::where('to_id', Auth::user()->id)
                ->where('seen', 0)->count();   
             
                $listInvitation = []; // Initialise un tableau pour les invitations
                $acceptedInvitations = collect(); // Initialise une collection vide
                $invitationsRecus = collect(); // Initialise une collection vide

                // Récupérer les invitations non acceptées envoyées par l'utilisateur
                $invitations = Invitation::where('inviter_id', $user->id)
                ->where('accepted', false)
                ->where('type', 'invite par salon')
                ->orderBy('created_at', 'desc')
                ->with(['invited'])
                ->get();

                if ($user->profile_type === "salon") {
                    // Récupérer les invitations non acceptées envoyées par l'utilisateur
                  $invitationsRecus = Invitation::where('invited_id', $user->id)
                  ->where('accepted', false)
                  ->where('type', 'associe au salon')
                   ->whereColumn('created_at', 'updated_at') 
                  ->with(['inviter'])
                  ->get();

                    $acceptedInvitations = Invitation::where(function ($query) use ($user) {
                        $query->where('inviter_id', $user->id)
                              ->orWhere('invited_id', $user->id); // Condition "OU" sur inviter_id et invited_id
                    })
                    ->whereIn('type', ['associe au salon', 'invite par salon']) // Types d'invitation
                    ->where('accepted', true) // Invitations acceptées
                    ->get()
                    ->map(function ($invitation) {
                        if ($invitation->type === 'associe au salon') {
                            $invitation->load('inviter.cantonget', 'inviter.villeget'); // Chargement des relations pour "associe au salon"
                        } elseif ($invitation->type === 'invite par salon') {
                            $invitation->load('invited.cantonget', 'invited.villeget'); // Chargement des relations pour "invite par salon"
                        }
                        return $invitation;
                    });
                    
                
                
                }

                if ($user->profile_type === "escorte") {
                    // Récupérer les invitations non acceptées envoyées par l'utilisateur
                  $invitationsRecus = Invitation::where('invited_id', $user->id)
                  ->where('accepted', false)
                  ->where('type', 'invite par salon')
                   ->whereColumn('created_at', 'updated_at') 
                  ->with(['inviter'])
                  ->get();

                  // Récupérer les invitations acceptées envoyées par l'utilisateur
                    $acceptedInvitations = Invitation::where('inviter_id', $user->id)
                    ->where('type', 'invite par salon')
                    ->where('accepted', true)
                    ->with(['invited.cantonget']) // Charge les informations de l'utilisateur invité
                    ->with(['invited.villeget'])
                    ->get();
                }

                // Étape 1 : Récupérer les `invited_id` en fonction des conditions
                $invitedIds = Invitation::where('inviter_id', $user->id)
                ->where(function ($query) {
                    $query->where('accepted', true)
                        ->orWhere(function ($subQuery) {
                            $subQuery->where('accepted', false)
                                    ->whereColumn('created_at', 'updated_at');
                        });
                })
                ->pluck('invited_id');

                // Étape 2 : Récupérer les utilisateurs "escorte" non invités
                $escortsNoInvited = User::where('profile_type', 'escorte')
                ->whereNotIn('id', $invitedIds)
                ->whereDoesntHave('invitations', function ($query) use ($user) {
                    $query->where('inviter_id', $user->id)
                        ->orWhere('invited_id', $user->id);
                })
                ->get();

                $salonAssociers = Invitation::where(function ($query) use ($user) {
                    $query->where('inviter_id', $user->id)
                          ->orWhere('invited_id', $user->id); // Condition "OU" sur inviter_id et invited_id
                })
                ->whereIn('type', ['associe au salon', 'invite par salon' ,'creer par salon']) // Types d'invitation
                ->where('accepted', true) // Invitations acceptées
                ->with([
                    'inviter.cantonget', 'inviter.villeget',
                    'invited.cantonget', 'invited.villeget'
                ]) // Chargement des relations pour éviter les requêtes supplémentaires
                ->get()
                ->map(function ($invitation) use ($user) {
                    $target = ($user->profile_type === 'salon')
                        ? ($invitation->type === 'associe au salon' ? 'inviter' : 'invited')
                        : ($invitation->type === 'associe au salon' ? 'invited' : 'inviter');
            
                    // Vérifie si la relation est bien chargée avant d'accéder aux propriétés
                    $invitation->load("{$target}.cantonget", "{$target}.villeget");
            
                    return $invitation;
                });

                // dd($salonAssociers);
            


                $inviterIds = Invitation::where('inviter_id', $user->id)
                ->where(function ($query) {
                    $query->where('accepted', true)
                        ->orWhere(function ($subQuery) {
                            $subQuery->where('accepted', false)
                                    ->whereColumn('created_at', 'updated_at');
                        });
                })
                ->pluck('invited_id');
                
                $salonsNoInvited = User::where('profile_type', 'salon')
                    ->whereNotIn('id', $invitedIds)
                    ->whereDoesntHave('invitations', function ($query) use ($user) {
                        $query->where('inviter_id', $user->id)
                            ->orWhere('invited_id', $user->id);
                    })
                    ->get();


            
                

                $invitationSalons = Invitation::where('inviter_id', $user->id)
                ->where('accepted', false)
                ->where('type', 'associe au salon')
                ->orderBy('created_at', 'desc')
                ->with(['invited'])
                ->get();

                $escorteCreateByUser = $user->escortes;

                $allrelation = Invitation::where('inviter_id', $user->id)
                    ->where('accepted', true)
                    ->where(function($query) {
                        $query->where('type', 'creer par salon')
                              ->orWhere('type', 'invite par salon');
                    })
                    ->orderByRaw("CASE WHEN type = 'creer par salon' THEN 0 ELSE 1 END")
                    ->get();
                


                $escorteCreateBySalons = Invitation::where('inviter_id', $user->id)
                ->where('accepted', true)
                ->where('type', 'creer par salon')
                ->with(['inviter.cantonget'])
                ->with(['inviter.villeget'])
                ->with(['invited'])
                ->get();


            //   dd($user);



                switch ($user->profile_type) {
                    case 'admin':
                        return view('admin.dashboard', ['user'=>$user , 'newCommentsCount' => $commentairesCount,]);
                   
                    default:
                        return view('auth.profile', [
                            'genres' => $genres,
                            'escorts' => $escorts,
                            'user' => $user,
                            'cantons' => $cantons,
                            'villes' => $villes,
                    'favoriteList' => $favoriteList,
                            'escort_categories' => $escort_categories,
                            'salon_categories' => $salon_categories,
                            'services' => $services,
                            'pratiquesSexuelles' => $pratiquesSexuelles,
                            'oriantationSexuelles' => $oriantationSexuelles,
                            'origines' => $origines,
                            'couleursYeux' => $couleursYeux,
                            'couleursCheveux' => $couleursCheveux,
                            'mensurations' => $mensurations,
                            'poitrines' => $poitrines,
                            'taillesPoitrine' => $taillesPoitrine,
                            'pubis' => $pubis,
                            'silhouette' => $silhouette,
                            'tatouages' => $tatouages,
                            'mobilites' => $mobilites,
                            'tarifs' => $tarifs,
                            'paiements' => $paiements,
                            'langues' => $langues,
                            'nombre_filles' => $nombreFilles,
                            'escortFavorites' => $escortFavorites,
                            'salonFavorites' => $salonFavorites,
                            'messageNoSeen' => $messageNoSeen,
                            'listInvitation' => $invitations,
                            'listInvitationSalons' => $invitationSalons,
                            'acceptedInvitations' => $acceptedInvitations,
                            'invitationsRecus' => $invitationsRecus,
                            'escortsNoInvited' => $escortsNoInvited,
                            'salonsNoInvited' => $salonsNoInvited,
                            'salonAssociers' => $salonAssociers,
                            'escorteCreateBySalons' => $escorteCreateBySalons,
                            'escorteCreateByUser' => $escorteCreateByUser,
                            'allrelation' => $allrelation,
                            ]);       
                }
        }else{
            return redirect()->route('home');
        }

    }
    
    // public function getDropdownData()
    // {
    //     //categories
    //     $categories = Categorie::all();
    //     $genres = Genre::all();
    //     $pratiquesSexuelles = PratiqueSexuelle::all();

       

    //     // Orientation Sexuelle
    //     $listeOrientationSexuelle = User::where('profile_type', 'escorte')->pluck('orientation_sexuelle_id')->unique();
    //     $oriantationSexuelles = OrientationSexuelle::whereIn('id', $listeOrientationSexuelle)->get();

    //     // origine
    //     $listeOrigine = User::where('profile_type', 'escorte')->pluck('origine')->unique();
    //     $listeOrigineItems = [];
    //     foreach ($listeOrigine as $origine) {
    //         if ($origine != null && $origine != '') {
    //             $listeOrigineItems[] = $origine;
    //         }
    //     }
    //     sort($listeOrigineItems, SORT_NATURAL | SORT_FLAG_CASE);
    //     $origines = $listeOrigineItems;


    //     //couleurs yeux
    //     $listeCouleurYeux = User::where('profile_type', 'escorte')->pluck('couleur_yeux_id')->unique();
    //     $couleursYeux = CouleurYeux::whereIn('id', $listeCouleurYeux)->get();

    //     //couleurs cheveux
    //     $listeCouleurCheveux = User::where('profile_type', 'escorte')->pluck('couleur_cheveux_id')->unique();
    //     $couleursCheveux = CouleurCheveux::whereIn('id', $listeCouleurCheveux)->get();

    //     //mensuration
    //     $listeMensuration = User::where('profile_type', 'escorte')->pluck('mensuration_id')->unique();
    //     $mensurations = Mensuration::whereIn('id', $listeMensuration)->get();

    //     //poitrine
    //     $listePoitrine = User::where('profile_type', 'escorte')->pluck('poitrine_id')->unique();
    //     $poitrines = Poitrine::whereIn('id', $listePoitrine)->get();

    //     //taille poitrine
    //     $listeTaillePoitrine = User::where('profile_type', 'escorte')->pluck('taille_poitrine')->unique();
    //     $liste = [];
    //     foreach ($listeTaillePoitrine as $taillePoitrine) {
    //         if ($taillePoitrine != null && $taillePoitrine != '') {
    //             $liste[] = $taillePoitrine;
    //         }
    //     }
    //     sort($liste, SORT_NATURAL | SORT_FLAG_CASE);
    //     $taillesPoitrine = $liste;

    //     // silhouette 
    //     $listeSilhouette = User::where('profile_type', 'escorte')->pluck('silhouette_id')->unique();
    //     $silhouette = Silhouette::whereIn('id', $listeSilhouette)->get();

    //     //pubis
    //     $listePubis = User::where('profile_type', 'escorte')->pluck('pubis_type_id')->unique();
    //     $pubis = PubisType::whereIn('id', $listePubis)->get();

    //     //tatouages
    //     $listeTatouage = User::where('profile_type', 'escorte')->pluck('tatoo_id')->unique();
    //     $tatouages = Tattoo::whereIn('id', $listeTatouage)->get();

    //     //mobilites
    //     $listeMobilite = User::where('profile_type', 'escorte')->pluck('mobilite_id')->unique();
    //     $mobilites = Mobilite::whereIn('id', $listeMobilite)->get();

    //     //paiements
    //     $paiementsArray = [];
    //     $listePaiements = User::where('profile_type', 'escorte')
    //         ->whereNotNull('paiement')
    //         ->where('paiement', '!=', '')
    //         ->pluck('paiement');
            
    //     foreach ($listePaiements as $paiementItem) {
    //         $paiementsExplode = explode(',', $paiementItem);
    //         foreach ($paiementsExplode as $paiement) {
    //             $paiement = trim($paiement);
    //             if (!empty($paiement) && !in_array($paiement, $paiementsArray)) {
    //                 $paiementsArray[] = $paiement;
    //             }
    //         }
    //     }
        
    //     sort($paiementsArray, SORT_NATURAL | SORT_FLAG_CASE);
    //     $paiements = array_values(array_unique($paiementsArray));


    //     //nombre filles
    //     $nombreFilles = NombreFille::all();


    //     //langues
    //     $languesArray = [];
    //     $listeLangues = User::where('profile_type', 'escorte')
    //         ->whereNotNull('langues')
    //         ->where('langues', '!=', '')
    //         ->pluck('langues');
            
    //     foreach ($listeLangues as $langueItem) {
    //         $languesExplode = explode(',', $langueItem);
    //         foreach ($languesExplode as $langue) {
    //             $langue = trim($langue);
    //             if (!empty($langue) && !in_array($langue, $languesArray)) {
    //                 $languesArray[] = $langue;
    //             }
    //         }
    //     }
        
    //     sort($languesArray, SORT_NATURAL | SORT_FLAG_CASE);
    //     $langues = array_values(array_unique($languesArray));

    //     //tarifs
    //     $tarifs = [100, 150, 200, 250, 300, 350, 400, 450, 500, 550, 600, 650, 700, 750, 800];

    //     return response()->json([
    //         'genres' => $genres,
    //         'oriantationSexuelles' => $oriantationSexuelles,
    //         'silhouette' => $silhouette,
    //         'categories' => $categories,
    //         'nombreFilles' => $nombreFilles,
    //         'pratiquesSexuelles' => $pratiquesSexuelles,
    //         'origines' => $origines,
    //         'langues' => $langues,
    //         'couleursYeux' => $couleursYeux,
    //         'couleursCheveux' => $couleursCheveux,
    //         'mensurations' => $mensurations,
    //         'poitrines' => $poitrines,
    //         'taillesPoitrine' => $taillesPoitrine,
    //         'pubis' => $pubis,
    //         'tatouages' => $tatouages,
    //         'mobilites' => $mobilites,
    //         'tarifs' => $tarifs,
    //         'paiements' => $paiements,
    //     ]);
    // }


    public function getDropdownData()
    {
        try {
            // Categories
            $categories = Cache::remember('categories', 60 * 60, function () {
                return Categorie::all();
            });
            $genres = Genre::all();
            $pratiquesSexuelles = PratiqueSexuelle::all();

            // Orientation Sexuelle
            // $listeOrientationSexuelle = User::where('profile_type', 'escorte')->pluck('orientation_sexuelle_id')->unique();
            // $oriantationSexuelles = OrientationSexuelle::whereIn('id', $listeOrientationSexuelle)->get();
            $oriantationSexuelles = Cache::remember('oriantationSexuelles', 60 * 60, function () {
                return OrientationSexuelle::all();
            });

            // Origine
            // $listeOrigine = User::where('profile_type', 'escorte')->pluck('origine')->unique();
            // $listeOrigineItems = [];
            // foreach ($listeOrigine as $origine) {
            //     if ($origine != null && $origine != '') {
            //         $listeOrigineItems[] = $origine;
            //     }
            // }
            // sort($listeOrigineItems, SORT_NATURAL | SORT_FLAG_CASE);
            // $origines = $listeOrigineItems;
            $origines = ['Italienne','Allemande', 'Française', 'Espagnole', 'Suissesse', 'Européene (Autres)', 'Asiatique', 'Africaine', 'Orientale', 'Brésilienne', 'Métissée', 'Autre'];
            

            // Couleurs yeux
            // $listeCouleurYeux = User::where('profile_type', 'escorte')->pluck('couleur_yeux_id')->unique();
            // $couleursYeux = CouleurYeux::whereIn('id', $listeCouleurYeux)->get();
            $couleursYeux = Cache::remember('couleursYeux', 60 * 60, function () {
                return CouleurYeux::all();
            });

            // Couleurs cheveux
            // $listeCouleurCheveux = User::where('profile_type', 'escorte')->pluck('couleur_cheveux_id')->unique();
            // $couleursCheveux = CouleurCheveux::whereIn('id', $listeCouleurCheveux)->get();
            $couleursCheveux = Cache::remember('couleursCheveux', 60 * 60, function () {
                return CouleurCheveux::all();
            });

            // Mensuration
            // $listeMensuration = User::where('profile_type', 'escorte')->pluck('mensuration_id')->unique();
            // $mensurations = Mensuration::whereIn('id', $listeMensuration)->get();
            $mensurations = Cache::remember('mensurations', 60 * 60, function () {
                return Mensuration::all();
            });

            // Poitrine
            // $listePoitrine = User::where('profile_type', 'escorte')->pluck('poitrine_id')->unique();
            // $poitrines = Poitrine::whereIn('id', $listePoitrine)->get();
            $poitrines = Cache::remember('poitrines', 60 * 60, function () {
                return Poitrine::all();
            });

            // Taille poitrine
            // $listeTaillePoitrine = User::where('profile_type', 'escorte')->pluck('taille_poitrine')->unique();
            // $liste = [];
            // foreach ($listeTaillePoitrine as $taillePoitrine) {
            //     if ($taillePoitrine != null && $taillePoitrine != '') {
            //         $liste[] = $taillePoitrine;
            //     }
            // }
            // sort($liste, SORT_NATURAL | SORT_FLAG_CASE);
            // $taillesPoitrine = $liste;
            $taillesPoitrine =['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];


            // Silhouette
            // $listeSilhouette = User::where('profile_type', 'escorte')->pluck('silhouette_id')->unique();
            // $silhouette = Silhouette::whereIn('id', $listeSilhouette)->get();
            $silhouette = Cache::remember('silhouette', 60 * 60, function () {
                return Silhouette::all();
            });

            // Pubis
            // $listePubis = User::where('profile_type', 'escorte')->pluck('pubis_type_id')->unique();
            // $pubis = PubisType::whereIn('id', $listePubis)->get();
            $pubis = Cache::remember('pubis', 60 * 60, function () {
                return PubisType::all();
            });

            // Tatouages
            // $listeTatouage = User::where('profile_type', 'escorte')->pluck('tatoo_id')->unique();
            // $tatouages = Tattoo::whereIn('id', $listeTatouage)->get();
            $tatouages = Cache::remember('tatouages', 60 * 60, function () {
                return Tattoo::all();
            });

            // Mobilités
            // $listeMobilite = User::where('profile_type', 'escorte')->pluck('mobilite_id')->unique();
            // $mobilites = Mobilite::whereIn('id', $listeMobilite)->get();
            $mobilites = Cache::remember('mobilites', 60 * 60, function () {
                return Mobilite::all();
            });

            // Paiements
            // $paiementsArray = [];
            // $listePaiements = User::where('profile_type', 'escorte')
            //     ->whereNotNull('paiement')
            //     ->pluck('paiement');

          

            // foreach ($listePaiements as $paiementItem) {
            //     $paiementsExplode = explode(',', $paiementItem);
            //     foreach ($paiementsExplode as $paiement) {
            //         $paiement = trim($paiement);
            //         if (!empty($paiement) && !in_array($paiement, $paiementsArray)) {
            //             $paiementsArray[] = $paiement;
            //         }
            //     }
            // }

            // sort($paiementsArray, SORT_NATURAL | SORT_FLAG_CASE);
            // $paiements = array_values(array_unique($paiementsArray));
            $paiements = ['CHF', 'Euros', 'Dollars', 'Twint', 'Visa', 'Mastercard', 'American Express', 'Maestro', 'Postfinance', 'Bitcoin'];


            // Nombre filles
            $nombreFilles = NombreFille::all();

            // Langues
            // $languesArray = [];
            // $listeLangues = User::where('profile_type', 'escorte')
            //     ->whereNotNull('langues')
            //     ->pluck('langues');

            // foreach ($listeLangues as $langueItem) {
            //     $languesExplode = explode(',', $langueItem);
            //     foreach ($languesExplode as $langue) {
            //         $langue = trim($langue);
            //         if (!empty($langue) && !in_array($langue, $languesArray)) {
            //             $languesArray[] = $langue;
            //         }
            //     }
            // }

            // sort($languesArray, SORT_NATURAL | SORT_FLAG_CASE);
            // $langues = array_values(array_unique($languesArray));
            $langues = ['Allemand', 'Anglais', 'Arabe', 'Espagnol', 'Français', 'Italien', 'Portugais', 'Russe', 'Autre'];


            // Tarifs
            $tarifs = [100, 150, 200, 250, 300, 350, 400, 450, 500, 550, 600, 650, 700, 750, 800];

            return response()->json([
                'genres' => $genres,
                'oriantationSexuelles' => $oriantationSexuelles,
                'silhouette' => $silhouette,
                'categories' => $categories,
                'nombreFilles' => $nombreFilles,
                'pratiquesSexuelles' => $pratiquesSexuelles,
                'origines' => $origines,
                'langues' => $langues,
                'couleursYeux' => $couleursYeux,
                'couleursCheveux' => $couleursCheveux,
                'mensurations' => $mensurations,
                'poitrines' => $poitrines,
                'taillesPoitrine' => $taillesPoitrine,
                'pubis' => $pubis,
                'tatouages' => $tatouages,
                'mobilites' => $mobilites,
                'tarifs' => $tarifs,
                'paiements' => $paiements,
            ]);

        } catch (\Exception $e) {
        
            return response()->json(['error' => 'Une erreur est survenue lors de la récupération des données.',
        'message' => $e->getMessage()], 500);
        }
    }





    public function getProfileCompletionPercentage()
    {
        $user = Auth::user();
        if($user->profile_type == 'escorte')
        {
            $totalFields = 32; // Total number of fields considered for completion
            $completedFields = 0;
        }elseif($user->profile_type == 'salon')
        {
            $totalFields = 21; // Total number of fields considered for completion
            $completedFields = 0;
        }else
        {
            $totalFields = 14; // Total number of fields considered for completion
            $completedFields = 0;
        }

        // Fields to consider for profile completion
        if($user->profile_type == 'escorte')
        {
            $fieldsToCheck = [
                // champ 1 : 8
                'genre_id',
                'prenom',
                'email',
                'telephone',
                'adresse',
                'npa',
                'canton',
                'ville',
                // champ 2 : 14
                'categorie',
                'pratique_sexuelle_id',
                'orientation_sexuelle_id',
                'service',
                'tailles',
                'origine',
                'couleur_yeux_id',
                'couleur_cheveux_id',
                'mensuration_id',
                'poitrine_id',
                'taille_poitrine',
                'pubis_type_id',
                'tatoo_id',
                'mobilite_id',
                'tarif',
                'langues',
                'paiement',
                'apropos',
                // champ 3 : 6
                'autre_contact',
                'complement_adresse',
                'lien_site_web',
                'localisation',
                'lat',
                'lon'
            ];
        }elseif($user->profile_type == 'salon')
        {
            $fieldsToCheck = [
                // champ 1 : 8
                'intitule',
                'nom_proprietaire',
                'email',
                'telephone',
                'adresse',
                'npa',
                'canton',
                'ville',
                // champ 2 : 7
                'categorie',
                'recrutement',
                'nombre_fille_id',            
                'tarif',
                'langues',
                'paiement',
                'apropos',
                // champ 3 : 6
                'autre_contact',
                'complement_adresse',
                'lien_site_web',
                'localisation',
                'lat',
                'lon',
                // 'nom_salon',

            ];
        }else
        {
            $fieldsToCheck = [
                // champ 1 : 8
                'genre_id',
                'pseudo',
                'email',
                'telephone',
                'adresse',
                'npa',
                'canton',
                'ville',
                // champ 2 : 6
                'autre_contact',
                'complement_adresse',
                'lien_site_web',
                'localisation',
                'lat',
                'lon',
            ];
        }

        foreach ($fieldsToCheck as $field) {
            if (!empty($user->$field)) {
                $completedFields++;
            }
        }

        if ($fieldsToCheck > 0) {
            $length = count($fieldsToCheck);
            $percentage = ($completedFields / $length) * 100;
        } else {
            $percentage = 0; // Avoid division by zero if no fields are considered
        }


        return response()->json(['percentage' => round($percentage)]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        // dd($request->all());

        $request->validate([
            'intitule' => 'nullable|string|max:255',
            'nom_proprietaire' => 'nullable|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'user_name' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'npa' => 'nullable|string|max:10',
            'canton' => 'nullable',
            'ville' => 'nullable',
            'categorie' => 'nullable',
            'service' => 'nullable',
            'orientation_sexuelle_id' => 'nullable|exists:orientation_sexuelles,id',
            'recrutement' => 'nullable|string|max:255',
            'nombre_fille_id' => 'nullable|exists:nombre_filles,id',
            'pratique_sexuelle_id' => 'nullable|exists:pratique_sexuelles,id',
            'tailles' => 'nullable|string|max:255',
            'origine' => 'nullable|string|max:255',
            'couleur_yeux_id' => 'nullable|exists:couleur_yeuxes,id',
            'couleur_cheveux_id' => 'nullable|exists:couleur_cheveuxes,id',
            'mensuration_id' => 'nullable|exists:mensurations,id',
            'poitrine_id' => 'nullable|exists:poitrines,id',
            'taille_poitrine' => 'nullable|string|max:255',
            'pubis_type_id' => 'nullable|exists:pubis_types,id',
            'tatoo_id' => 'nullable|exists:tattoos,id',
            'mobilite_id' => 'nullable|exists:mobilites,id',
            'tarif' => 'nullable|string|max:255',
            'langues' => 'nullable|string|max:255',
            'paiement' => 'nullable|string|max:255',
            'apropos' => 'nullable|string',
            'autre_contact' => 'nullable|string|max:255',
            'complement_adresse' => 'nullable|string|max:255',
            'lien_site_web' => 'nullable|url|max:255',
            'localisation' => 'nullable|string|max:255',
            'lat' => 'nullable|string|max:255',
            'lon' => 'nullable|string|max:255',
            'lang' => 'required|in:fr,en-US,es,de,it' ,
            'genre_id' => 'nullable|exists:genres,id',

            // Ajoutez les règles de validation pour les autres champs
        ]);

        // dd($request->all());



       if($request->apropos){
         // Langues cibles pour les traductions
         $locales = Locales::SUPPORTED_CODES;
         $sourceLocale = $request['lang']; // Langue source par défaut
         // Traduire le contenu dans toutes les langues cibles
         $translatedContent = [];
         foreach ($locales as $locale) {
             if ($locale !== $sourceLocale) {
                 $translatedContent[$locale] = $this->translateService->translate($request['apropos'], $locale);
             }else{
                 $translatedContent[$locale] = $request['apropos'];
             }
         }
 
         $request['apropos'] = $translatedContent;
 
       }

        // $request->categorie? $request['categorie'] = (int)$request->categorie : null;

        $user->update($request->all());

        // Recalculate percentage after update
        $percentageResponse = $this->getProfileCompletionPercentage();
        $percentage = $percentageResponse->getData()->percentage;

        $user->notify(new ComplementationNotification($percentage));

        return redirect()->route('profile.index')
            ->with('success', __('profile.success.profile_updated'))
            ->with('completionPercentage', $percentage);
    }

    public function updatePhoto(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'photo_profil' => ['sometimes', 'nullable', 'file', 'image', 'mimes:jpeg,png,jpg'],
            'photo_couverture' => ['sometimes', 'nullable', 'file', 'image', 'mimes:jpeg,png,jpg'],
        ]);
        if ($request->hasFile('photo_profil') && $request->file('photo_profil')->isValid()) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->avatar) {
                Storage::delete('public/avatars/' . $user->avatar);
            }

            // Générer un nom unique pour la nouvelle photo
            $filename = Str::slug($user->user_name ?? $user->nom_salon ?? $user->name) . '-' . time() . '.' . $request->file('photo_profil')->extension();
            // Stocker la photo
            $request->file('photo_profil')->storeAs('public/avatars', $filename);

            // Mettre à jour la photo de profil de l'utilisateur
            $user->update(['avatar' => $filename]);

            return redirect()->back()->with('success', __('profile.success.profile_photo_updated'));
        }
        if ($request->hasFile('photo_couverture') && $request->file('photo_couverture')->isValid()) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->couverture_image) {
                Storage::delete('public/couvertures/' . $user->couverture_image);
            }

            // Générer un nom unique pour la nouvelle photo
            $filename = Str::slug($user->user_name ?? $user->nom_salon ?? $user->name) . '-' . time() . '.' . $request->file('photo_couverture')->extension();
            // Stocker la photo
            $request->file('photo_couverture')->storeAs('public/couvertures', $filename);

            // Mettre à jour la photo de profil de l'utilisateur
            $user->update(['couverture_image' => $filename]);

            return redirect()->back()->with('success', __('profile.success.profile_photo_updated'));
        }

        return redirect()->back()->with('error', __('profile.errors.profile_photo_update_failed'));
    }

    public function updateVerification(Request $request)
    {

        $user = auth()->user();
    
        // Valider les données de la requête
        $request->validate([
            'profile_verifie' => 'required|string|in:verifier,non verifier,en cours',
            'image_verification' => ['sometimes', 'nullable', 'file', 'image', 'mimes:jpeg,png,jpg'],
        ]);
    
        // Mettre à jour uniquement le champ 'profile_verifie'
       

        if ($request->hasFile('image_verification') && $request->file('image_verification')->isValid()) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->avatar) {
                Storage::delete('public/verificationImage/' . $user->avatar);
            }

            // Générer un nom unique pour la nouvelle photo
            $filename = Str::slug($user->user_name ?? $user->nom_salon ?? $user->name) . '-' . time() . '.' . $request->file('image_verification')->extension();
            // Stocker la photo
            $request->file('image_verification')->storeAs('public/verificationImage', $filename);

            // Mettre à jour la photo de profil de l'utilisateur
            $user->update(['image_verification' => $filename]);
            $user->update([
                'profile_verifie' => $request->input('profile_verifie'),
            ]);

            // // Envoyer une notification à l'administrateur
            // $admin = User::where('profile_type', 'admin')->first(); // Assurez-vous que l'admin existe
            // if ($admin) {
            //     $admin->notify(new ProfileVerificationRequestNotification($user));
            // }

            $admins = User::where('profile_type', 'admin')->get(); // Récupérer tous les administrateurs
            foreach ($admins as $admin) {
                $admin->notify(new ProfileVerificationRequestNotification($user));
            }
        
            // Rediriger avec un message de succès
            return redirect()->route('profile.index')
                ->with('success', __('profile.success.verification_request_sent'));

            }

        

    }


    public function getDropdownDataAdmin()
    {
        try {
            $categories = Categorie::all()->map(function ($categorie) {
                $count = User::where('profile_type', 'escorte')
                    ->whereRaw("categorie::jsonb @> ?", [json_encode($categorie->id)])
                    ->count();
            
                $categorie->users_count = $count;
                return $categorie;
            });

            $services = Service::withCount(['users' => function ($query) {
                $query->where('profile_type', 'escorte');
            }])->with('categorie')->get();

            
            $genres = Genre::withCount(['users' => function ($query) {
                $query->where('profile_type', 'escorte');
            }])->get();
    
            $pratiquesSexuelles = PratiqueSexuelle::withCount(['users' => function ($query) {
                $query->where('profile_type', 'escorte');
            }])->get();
    
            $orientationSexuelle = OrientationSexuelle::withCount(['users' => function ($query) {
                $query->where('profile_type', 'escorte');
            }])->get();
    
            $couleursYeux = CouleurYeux::withCount(['users' => function ($query) {
                $query->where('profile_type', 'escorte');
            }])->get();
    
            $couleursCheveux = CouleurCheveux::withCount(['users' => function ($query) {
                $query->where('profile_type', 'escorte');
            }])->get();
    
            $mensurations = Mensuration::withCount(['users' => function ($query) {
                $query->where('profile_type', 'escorte');
            }])->get();
    
            $poitrines = Poitrine::withCount(['users' => function ($query) {
                $query->where('profile_type', 'escorte');
            }])->get();
    
            $silhouette = Silhouette::withCount(['users' => function ($query) {
                $query->where('profile_type', 'escorte');
            }])->get();
    
            $pubis = PubisType::withCount(['users' => function ($query) {
                $query->where('profile_type', 'escorte');
            }])->get();
    
            $tatouages = Tattoo::withCount(['users' => function ($query) {
                $query->where('profile_type', 'escorte');
            }])->get();
    
            $mobilites = Mobilite::withCount(['users' => function ($query) {
                $query->where('profile_type', 'escorte');
            }])->get();
    
            $nombreFilles = NombreFille::withCount(['users' => function ($query) {
                $query->where('profile_type', 'salon');
            }])->get();

            $dropCategories = Categorie::where('type', 'escort')->get();
    
            return response()->json([
                'genres' => $genres,
                'orientationSexuelle' => $orientationSexuelle,
                'silhouette' => $silhouette,
                'categories' => $categories,
                'pratiquesSexuelles' => $pratiquesSexuelles,
                'couleursYeux' => $couleursYeux,
                'couleursCheveux' => $couleursCheveux,
                'mensurations' => $mensurations,
                'poitrines' => $poitrines,
                'pubis' => $pubis,
                'tatouages' => $tatouages,
                'mobilites' => $mobilites,
                'nombreFilles' => $nombreFilles,
                'services' => $services,
                'dropCategories' => $dropCategories,    
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Une erreur est survenue lors de la récupération des données.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    
}
