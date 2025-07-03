<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Canton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail; // Vous devrez créer ce Mail plus tard
use App\Models\Categorie;
use App\Models\Gallery;
use App\Models\Notification;
use App\Models\Invitation;
use App\Models\Service;
use App\Models\Story;
use App\Models\Ville;
use App\Models\SalonEscorte;
use Illuminate\Support\Facades\Cache;
use App\Services\DeepLTranslateService;
use App\Helpers\Locales;


class AuthController extends Controller
{
    protected $translateService;

    public function __construct(DeepLTranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    public function showRegistrationForm()
    {
      if (Auth::check()) {
        $user = Auth::user();
        return view('auth.profile', ['user' => $user]);
      }
      return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_type' => 'required|in:invite,escorte,salon',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
            'date_naissance' => 'required|date|before:' . now()->subYears(18)->toDateString(),
            'cgu_accepted' => 'accepted',
            'pseudo' => 'required_if:profile_type,invite|nullable|string|max:255',
            'prenom' => 'required_if:profile_type,escorte|nullable|string|max:255',
            'genre_id' => 'required_if:profile_type,escorte|nullable|exists:genres,id',
            'nom_salon' => 'required_if:profile_type,salon|nullable|string|max:255',
            'intitule' => 'required_if:profile_type,salon|nullable|in:monsieur,madame,mademoiselle,autre',
            'nom_proprietaire' => 'required_if:profile_type,salon|nullable|string|max:255',
        ], [
            'profile_type.required' => __('validation.profile_type.required'),
            'profile_type.in' => __('validation.profile_type.in'),
            'email.required' => __('validation.email.required'),
            'email.email' => __('validation.email.email'),
            'email.only' => __('validation.email.only'),
            'password.required' => __('validation.password.required'),
            'password.confirmed' => __('validation.password.confirmed'),
            'password.min' => __('validation.password.min'),
            'date_naissance.required' => __('validation.date_naissance.required'),
            'date_naissance.date' => __('validation.date_naissance.date'),
            'date_naissance.before' => __('validation.date_naissance.before'),
            'cgu_accepted.accepted' => __('validation.cgu_accepted.accepted'),
            'pseudo.required_if' => __('validation.pseudo.required_if'),
            'pseudo.string' => __('validation.pseudo.string'),
            'pseudo.max' => __('validation.pseudo.max'),
            'prenom.required_if' => __('validation.prenom.required_if'),
            'prenom.string' => __('validation.prenom.string'),
            'prenom.max' => __('validation.prenom.max'),
            'genre_id.required_if' => __('validation.genre_id.required_if'),
            'genre_id.exists' => __('validation.genre_id.exists'),
            'nom_salon.required_if' => __('validation.nom_salon.required_if'),
            'nom_salon.string' => __('validation.nom_salon.string'),
            'nom_salon.max' => __('validation.nom_salon.max'),
            'intitule.required_if' => __('validation.intitule.required_if'),
            'intitule.in' => __('validation.intitule.in'),
            'nom_proprietaire.required_if' => __('validation.nom_proprietaire.required_if'),
            'nom_proprietaire.string' => __('validation.nom_proprietaire.string'),
            'nom_proprietaire.max' => __('validation.nom_proprietaire.max'),
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', __('auth.registration.validation_error'));
        }

        $user = User::create([
            'profile_type' => $request->profile_type,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'date_naissance' => $request->date_naissance,
            'pseudo' => $request->pseudo,
            'prenom' => $request->prenom,
            'genre_id' => $request->genre_id,
            'nom_salon' => $request->nom_salon,
            'intitule' => $request->intitule,
            'nom_proprietaire' => $request->nom_proprietaire,
        ]);

        Auth::login($user); // Connecte automatiquement l'utilisateur après l'inscription

        return redirect()->route('profile.index')
            ->with('success', __('auth.registration.success'));
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tenter la connexion
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // Vérifier si l'utilisateur a le champ createBySalon à true
            $user = Auth::user(); // Récupère l'utilisateur connecté
            if ($user->createbysalon) {
                Auth::logout(); // Déconnecter immédiatement l'utilisateur
                return response()->json([
                    'success' => false, 
                    'message' => __('auth.login.salon_managed')
                ], 403);
            }

            // Si tout est bon, autoriser l'accès
            return response()->json([
                'success' => true, 
                'message' => __('auth.login.success')
            ]);
        }

        // Identifiants incorrects
        return response()->json([
            'success' => false, 
            'message' => __('auth.failed')
        ], 401);
    }

    public function logout(Request $request)
    {
        // Enregistrer le dernier timestamp avant déconnexion
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $user->last_seen_at = now();
            $user->save();
            // Supprimer le cache de l'utilisateur
            Cache::forget('user-is-online-' . $user->id);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')
            ->with('info', __('auth.logout_success'));
    }

    public function showPasswordResetRequestForm()
    {
        return view('auth.password_reset_request');
    }

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => __('auth.email_not_found')
        ]);

        $user = User::where('email', $request->email)->first();
        $token = Str::random(60); // Générer un token unique
        $user->password_reset_token = $token;
        $user->password_reset_expiry = now()->addHour(); // Token expire dans 1 heure
        $user->save();

        // Envoyer l'email de réinitialisation (vous devrez configurer Mailtrap ou un service d'email réel)
        // Mail::to($user->email)->send(new PasswordResetMail($user, $token));

        return response()->json([
            'success' => true, 
            'message' => __('auth.reset_link_sent')
        ]);
    }

    public function showPasswordResetForm(string $token)
    {
        $user = User::where('password_reset_token', $token)
                     ->where('password_reset_expiry', '>', now())
                     ->first();

        if (!$user) {
            return redirect()->route('password.request')
                ->withErrors(['token' => __('auth.invalid_token')]);
        }

        return view('auth.password_reset_form', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::where('email', $request->email)
                     ->where('password_reset_token', $request->token)
                     ->where('password_reset_expiry', '>', now())
                     ->first();

        if (!$user) {
            return back()->withInput()->withErrors(['token' => 'Token de réinitialisation invalide ou expiré.']);
        }

        $user->password = Hash::make($request->password);
        $user->password_reset_token = null;
        $user->password_reset_expiry = null;
        $user->save();

        return redirect()->route('login')->with('success', 'Mot de passe réinitialisé avec succès. Veuillez vous connecter avec votre nouveau mot de passe.');
    }


    /**
     * Gère l'affichage du profil de l'utilisateur connecté en fonction de son type de profil.
     *
     * - Si l'utilisateur n'est pas connecté, il sera redirigé vers la page d'accueil.
     * - Charge les informations spécifiques en fonction du type de profil de l'utilisateur :
     *   - Pour un utilisateur de type "salon", les invitations envoyées et reçues sont incluses.
     *   - Pour un administrateur, la vue du tableau de bord est chargée.
     *   - Par défaut, pour les autres profils, seules les informations de base sont affichées.
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Routing\Redirector
     * - Une vue contenant les informations du profil.
     * - Ou une redirection si l'utilisateur n'est pas connecté.
     */
    public function profile()
    {
        // Vérification : l'utilisateur doit être connecté
        if (!Auth::check()) {
            return redirect()->route('home'); // Redirige vers la page d'accueil si non authentifié
        }

        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        // Associer le canton à l'utilisateur
        $user->canton = Canton::find($user->canton);

        // Récupérer les utilisateurs avec le type de profil "escorte"
        $escorts = User::where('profile_type', 'escorte')->get();

        // Initialiser le tableau des invitations
        $listInvitation = [];

        // Récupérer les invitations non acceptées envoyées par l'utilisateur
        $invitations = Invitation::where('inviter_id', $user->id)
                                ->where('type', 'invite par salon')
                                ->where('accepted', false)
                                ->get();

        // Récupérer les invitations non acceptées reçues par l'utilisateur
        $invitationsRecus = Invitation::where('invited_id', $user->id)
                                    ->where('accepted', false)
                                    ->where('type', 'invite par salon')
                                    ->with(['inviter'])
                                    ->get();

        // Récupérer les invitations acceptées envoyées par l'utilisateur
        $acceptedInvitations = Invitation::where('inviter_id', $user->id)
                                        ->where('type', 'invite par salon')
                                        ->where('accepted', true)
                                        ->with(['invited.cantonget']) // Charge les informations de l'utilisateur invité
                                        ->with(['invited.villeget'])  // Charge les informations de l'utilisateur invité
                                        ->get();

        // Préparer la liste des invitations
        foreach ($invitations as $invitation) {
            $listInvitation[] = [
                'dateNotification' => $invitation->created_at, // Date de création de l'invitation
                'userInvited' => User::find($invitation->invited_id), // Détails de l'utilisateur invité
            ];
        }

        // Récupérer les favoris de type "escort"
        $escortFavorites = $user->favorites()->where('profile_type', 'escorte')->get();
        foreach ($escortFavorites as $escort) {
            $escort['canton'] = Canton::find($escort->canton);
            $escort['ville'] = Ville::find($escort->ville);
            $escort['categorie'] = Categorie::find($escort->categorie);
            $escort['service'] = Service::find($escort->service);
            // dd($escort->service);
        }
        // Récupérer les favoris de type "salon"
        $salonFavorites = $user->favorites()->where('profile_type', 'salon')->get();
        foreach ($salonFavorites as $escort) {
            $escort['canton'] = Canton::find($escort->canton);
            $escort['ville'] = Ville::find($escort->ville);
            $escort['categorie'] = Categorie::find($escort->categorie);
            $escort['service'] = Service::find($escort->service);
            // dd($escort->service);
        }

        // Afficher une vue basée sur le type de profil de l'utilisateur
        switch ($user->profile_type) {
            case 'salon':
                // Vue pour les utilisateurs de type "salon" avec les invitations
                return view('auth.profile', compact('user', 'escorts', 'listInvitation', 'acceptedInvitations', 'invitationsRecus','escortFavorites','salonFavorites' ));

            case 'admin':
                // Vue pour les administrateurs
                return view('admin.dashboard', compact('user'));

            default:
                // Vue par défaut pour les autres types de profils
                return view('auth.profile', compact('user', 'escorts','escortFavorites','salonFavorites' ));
        }
    }

    public function editService(Request $request)
    {
        // dd($request->get('service'));
        $user = auth()->user();
        $user->categorie = $request->get('categorie');
        $user->service = $request->get('service');
        $user->save();

        return redirect()->route('profile.index') ->with('success', __('profile.success.profile_updated'));
    }

    public function createEscorteBySalon(Request $request)
    {

        // Validation des données
        $validator = Validator::make($request->all(), [
            'id_salon' => 'required|exists:users,id', // Vérifie que le salon existe
            'email' => 'required|email|unique:users',
            'date_naissance' => 'required|date|before:' . now()->subYears(18)->toDateString(), // Vérifie l'âge minimum de 18 ans
            'prenom' => 'required|string|max:255', 
            'genre_id' => 'required|exists:genres,id', 
            'telephone' => [
                'nullable',
                'string',
                'max:15', 
                'regex:/^[0-9]{10}$/', 
                
            ],
            'adresse' => 'nullable|string|max:255',
            'npa' => 'nullable|string|max:10',
            'canton' => 'nullable|exists:cantons,id',
            'ville' => 'nullable|exists:villes,id',
            'categorie' => 'nullable|exists:categories,id', 
            'pratique_sexuelle_id' => 'nullable|exists:pratique_sexuelles,id',
            'orientation_sexuelle_id' => 'nullable|exists:orientation_sexuelles,id',
            'service' => 'nullable',
            'tailles' => 'nullable|integer',
            'pubis_id' => 'nullable|exists:pubises,id',
            'origine' => 'nullable|string|max:255',
            'couleur_yeux_id' => 'nullable|exists:couleur_yeuxes,id',
            'couleur_cheveux_id' => 'nullable|exists:couleur_cheveuxes,id',
            'mensuration' => 'nullable|string|max:255',
            'poitrine' => 'nullable|string|max:255',
            'taille_poitrine' => 'nullable|string|max:255',
            'tatoo_id' => 'nullable|exists:tattoos,id',
            'mobilite_id' => 'nullable|exists:mobilites,id',
            'langues' => 'nullable|string|max:255',
            'paiement' => 'nullable|string|max:255',
            'tarif' => 'nullable|string|max:255',
            'autre_contact' => 'nullable|string|max:255',
            'complement_adresse' => 'nullable|string|max:255',
            'lien_site_web' => 'nullable|url',
            'apropos' => 'nullable|string|max:1000',
            'lang' => 'required|in:fr,en-US,es,de,it' 
        ]);

    
        // Langues cibles pour les traductions
        $locales = Locales::SUPPORTED_CODES;
        $sourceLocale = $request['lang']; // Langue source par défaut
        // Traduire le contenu dans toutes les langues cibles
       
        if (!empty($request->apropos)) {
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

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Récupérer le salon
        $salon = User::find($request->id_salon);

        if (!$salon) {
            return back()->with('error', 'Salon non trouvé.');
        }
        $pwd = 'password';

        // Création de l'utilisateur
        $user = User::create([
            'profile_type' => 'escorte',
            'email' => $request->email,
            'password' => Hash::make($pwd),
            'date_naissance' => $request->date_naissance,
            'pseudo' => $request->prenom,
            'prenom' => $request->prenom,
            'genre_id' => $request->genre_id,
            'nom_salon' => $salon->nom_salon,
            'createbysalon' => true,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'npa' => $request->npa,
            'canton' => $request->canton,
            'ville' => $request->ville,
            'categorie' => $request->categorie,
            'pratique_sexuelle_id' => $request->pratique_sexuelle_id,
            'orientation_sexuelle_id' => $request->orientation_sexuelle_id,
            'service' => $request->service,
            'tailles' => $request->tailles,
            'pubis_type_id' => $request->pubis_type_id,
            'origine' => $request->origine,
            'couleur_yeux_id' => $request->couleur_yeux_id,
            'couleur_cheveux_id' => $request->couleur_cheveux_id,
            'mensuration_id' => $request->mensuration_id ?? null,
            'poitrine_id' => $request->poitrine_id,
            'taille_poitrine' => $request->taille_poitrine,
            'tatoo_id' => $request->tatoo_id,
            'mobilite_id' => $request->mobilite_id,
            'langues' => $request->langues,
            'tarif' => $request->tarif,
            'paiement' => $request->paiement,
            'autre_contact' => $request->autre_contact,
            'complement_adresse' => $request->complement_adresse,
            'lien_site_web' => $request->lien_site_web,
            'apropos' => $request->apropos,
        ]);

        

        // Création de l'invitation
        Invitation::create([
            'inviter_id' => $salon->id, // ID du salon qui invite
            'invited_id' => $user->id,  // ID de l'utilisateur invité
            'accepted' => true,         // Invitation acceptée par défaut
            'type' => 'creer par salon',
        ]);

        SalonEscorte::create([
            'salon_id' => $salon->id, // ID du salon qui invite
            'escorte_id' => $user->id,  // ID de l'utilisateur invité
        ]);
        

        return response()->json(['status' => 200 ]);
    }

    public function showGallery()
    {
        // Récupérer les utilisateurs avec leurs stories actives, avec le décompte
        $usersWithStories = User::whereHas('stories', function($query) {
                $query->where('expires_at', '>', now());
            })
            ->withCount(['stories' => function($query) {
                $query->where('expires_at', '>', now());
            }])
            ->with(['stories' => function($query) {
                $query->where('expires_at', '>', now())
                      ->orderBy('created_at', 'desc');
            }])
            ->get()
            ->map(function($user) {
                // Récupérer l'avatar de l'utilisateur
                $avatarUrl = $user->avatar ? asset('storage/avatars/' . $user->avatar) : asset('images/icon_logo.png');
                
                // Préparer les stories avec les URLs complètes
                $stories = $user->stories->map(function($story) {
                    return [
                        'id' => $story->id,
                        'media_path' => asset('storage/' . $story->media_path),
                        'media_type' => $story->media_type,
                        'created_at' => $story->created_at,
                        'expires_at' => $story->expires_at,
                        'user_id' => $story->user_id
                    ];
                });
                
                return [
                    'id' => $user->id,
                    'name' => $user->pseudo ?? $user->prenom ?? $user->nom_salon ?? 'Utilisateur',
                    'avatar' => $avatarUrl,
                    'stories_count' => $user->stories_count,
                    'stories' => $stories
                ];
            });

        return view('gallery', [
            'usersWithStories' => $usersWithStories,
            'usersWithMedia' => User::has('galleries')->get(),
            'publicGallery' => Gallery::where('is_public', true)
                ->with('user')
                ->latest()
                ->paginate(12),
            'privateGallery' => Gallery::where('is_public', false)
                ->with('user')
                ->latest()
                ->paginate(12),
        ]);
    }

    public function apiPublicGallery()
    {
        return Gallery::where('is_public', true)
            ->with('user')
            ->latest()
            ->paginate(12);
    }

    public function apiPrivateGallery()
    {
        return Gallery::where('is_public', false)
            ->with('user')
            ->latest()
            ->paginate(12);
    }

}
