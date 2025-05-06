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

class AuthController extends Controller
{
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
            'date_naissance' => 'required|date|before:' . now()->subYears(18)->toDateString(), // Vérification de l'âge (18 ans minimum)
            'cgu_accepted' => 'accepted', // Pour le profil Invité
            'pseudo' => 'required_if:profile_type,invite|nullable|string|max:255', // Pour Invité
            'prenom' => 'required_if:profile_type,escorte|nullable|string|max:255', // Pour Escorte
            'genre' => 'required_if:profile_type,escorte|nullable|in:homme,femme,non-binaire,autre', // Pour Escorte
            'nom_salon' => 'required_if:profile_type,salon|nullable|string|max:255', // Pour Salon
            'intitule' => 'required_if:profile_type,salon|nullable|in:monsieur,madame,mademoiselle,autre', // Pour Salon
            'nom_proprietaire' => 'required_if:profile_type,salon|nullable|string|max:255', // Pour Salon
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Problème de validation');
            dd($validator);
        }

        $user = User::create([
            'profile_type' => $request->profile_type,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'date_naissance' => $request->date_naissance,
            'pseudo' => $request->pseudo,
            'prenom' => $request->prenom,
            'genre' => $request->genre,
            'nom_salon' => $request->nom_salon,
            'intitule' => $request->intitule,
            'nom_proprietaire' => $request->nom_proprietaire,
        ]);

        Auth::login($user); // Connecte automatiquement l'utilisateur après l'inscription

        return redirect()->route('profile.index')->with('success', 'Inscription réussie ! Bienvenue.');
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
                'message' => 'Votre compte est actuellement géré par un salon. Veuillez contacter l\'administration.'
            ], 403);
        }

        // Si tout est bon, autoriser l'accès
        return response()->json(['success' => true, 'message' => 'Authentification réussie']);
    }

    // Identifiants incorrects
    return response()->json(['success' => false, 'message' => 'Identifiants incorrects'], 401);
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
        return redirect()->route('home')->with('info', 'Déconnexion réussie.');
    }

    public function showPasswordResetRequestForm()
    {
        return view('auth.password_reset_request');
    }

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();
        $token = Str::random(60); // Générer un token unique
        $user->password_reset_token = $token;
        $user->password_reset_expiry = now()->addHour(); // Token expire dans 1 heure
        $user->save();

        // Envoyer l'email de réinitialisation (vous devrez configurer Mailtrap ou un service d'email réel)
        // Mail::to($user->email)->send(new PasswordResetMail($user, $token));

        // return back()->with('success', 'Un lien de réinitialisation de mot de passe a été envoyé à votre adresse email.');
        return response()->json(['success' => true, 'message' => 'Un lien de réinitialisation de mot de passe a été envoyé à votre adresse email.']);
    }

    public function showPasswordResetForm(string $token)
    {
        $user = User::where('password_reset_token', $token)
                     ->where('password_reset_expiry', '>', now())
                     ->first();

        if (!$user) {
            return redirect()->route('password.request')->withErrors(['token' => 'Token de réinitialisation invalide ou expiré.']);
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

public function createEscorteBySalon(Request $request)
{
    // Convertir les chaînes en tableaux
    $request->merge([
        'service' => explode(',', $request->service),
        'langues' => explode(',', $request->langues),
        'paiement' => explode(',', $request->paiement),
    ]);

    // Validation des données
    $validator = Validator::make($request->all(), [
        'id_salon' => 'required|exists:users,id', // Vérifie que le salon existe
        'email' => 'required|email|unique:users',
        'date_naissance' => 'required|date|before:' . now()->subYears(18)->toDateString(), // Vérifie l'âge minimum de 18 ans
        'prenom' => 'required|string|max:255', // Pour Escorte
        'genre' => 'required|string|in:Femme,Homme,Trans,Gay,Lesbienne,Bisexuelle,Queer', // Ajout de la validation pour le genre
        'telephone' => [
            'nullable',
            'string',
            'max:15', // Adjust max length if needed
            'regex:/^[0-9]{10}$/', // Example regex for a 10-digit number
            
        ],
        'adresse' => 'nullable|string|max:255',
        'npa' => 'nullable|string|max:10',
        'canton' => 'nullable|exists:cantons,id',
        'ville' => 'nullable|exists:villes,id',
        'categorie' => 'nullable|exists:categories,id', // Assurez-vous que le nom de la table est correct
        'pratique_sexuelles' => 'nullable|string|max:255',
        'oriantation_sexuelles' => 'nullable|string|max:255',
        'service' => 'nullable|array',
        'tailles' => 'nullable|integer',
        'pubis' => 'nullable|string|max:255',
        'origine' => 'nullable|string|max:255',
        'couleur_yeux' => 'nullable|string|max:255',
        'couleur_cheveux' => 'nullable|string|max:255',
        'mensuration' => 'nullable|string|max:255',
        'poitrine' => 'nullable|string|max:255',
        'taille_poitrine' => 'nullable|string|max:255',
        'tatouages' => 'nullable|string|max:255',
        'mobilite' => 'nullable|string|max:255',
        'langues' => 'nullable|array',
        'tarif' => 'nullable|string|max:255',
        'paiement' => 'nullable|array',
        'autre_contact' => 'nullable|string|max:255',
        'complement_adresse' => 'nullable|string|max:255',
        'lien_site_web' => 'nullable|url',
        'apropos' => 'nullable|string|max:1000',
    ]);
    


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
        'genre' => $request->genre,
        'nom_salon' => $salon->nom_salon,
        'createbysalon' => true,
        'telephone' => $request->telephone,
        'adresse' => $request->adresse,
        'npa' => $request->npa,
        'canton_id' => $request->canton,
        'ville_id' => $request->ville,
        'categorie_id' => $request->categorie,
        'pratique_sexuelles' => $request->pratique_sexuelles,
        'oriantation_sexuelles' => $request->oriantation_sexuelles,
        'service' => json_encode($request->service),
        'tailles' => $request->tailles,
        'pubis' => $request->pubis,
        'origine' => $request->origine,
        'couleur_yeux' => $request->couleur_yeux,
        'couleur_cheveux' => $request->couleur_cheveux,
        'mensuration' => $request->mensuration,
        'poitrine' => $request->poitrine,
        'taille_poitrine' => $request->taille_poitrine,
        'tatouages' => $request->tatouages,
        'mobilite' => $request->mobilite,
        'langues' => json_encode($request->langues),
        'tarif' => $request->tarif,
        'paiement' => json_encode($request->paiement),
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

    return redirect()->route('profile.index')->with('success', 'Inscription réussie ! Bienvenue.');
}





public function showGallery()
{
    return view('auth.gallery', [
        'usersWithStories' => Story::with('user')
        ->where('expires_at', '>', now())
        ->get()
        ->groupBy('user_id')
        ->collect(),
        'usersWithMedia' => User::has('galleries')->get(),
        'publicGallery' => Gallery::where('is_public', true)->with('user')->latest()->get(),
        'privateGallery' => Gallery::where('is_public', false)->with('user')->latest()->get(),
    ]);
}


}
