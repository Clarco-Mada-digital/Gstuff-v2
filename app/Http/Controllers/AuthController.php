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
use App\Models\Notification;
use App\Models\Invitation;


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

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            // return redirect()->intended(route('profile'))->with('success', 'Connexion réussie !');
            return response()->json(['success' => true, 'message' => 'Authentification réussie']);
        }

        // return back()->withErrors([
        //     'email' => 'Email ou mot de passe incorrect.',
        // ])->onlyInput('email');
        return response()->json(['success' => false, 'message' => 'Identifiants incorrects'], 401);
    }

    public function logout(Request $request)
    {
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

    // public function profile()
    // {
    //     if (Auth::check()) {
    //         // $user = Auth::user()->load('canton');
    //         $user = Auth::user();
    //         $user['canton'] = Canton::find($user->canton);

    //         $escorts = User::where('profile_type', 'escorte')->get();
    //         dd($user);

    //         if ($user) {
    //             // Lister les invitations envoyées par le user
    //             $notifications = Notification::where('type', 'App\Notifications\EscortInvitationNotification')->get();
    //             $listInvitation = []; // Déclaration du tableau
    
    //             foreach ($notifications as $notification) {
    //                 if (isset($notification->data['inviter_id']) && $notification->data['inviter_id'] === $user->id) {
    //                     $listInvitation[] = [
    //                         'dateNotification' => $notification->created_at,
    //                         'readAt' => $notification->read_at,
    //                         'userInvited' => User::findOrFail($notification->data['inviter_id']) // Corrigé pour récupérer le bon utilisateur
    //                     ];
    //                 }
    //             }
    //         }
    //         if ($user->profile_type == 'salon') {
    //             return view('auth.profile', ['user' => $user, 'escorts' => $escorts , 'listInvitation'=>$listInvitation]);
    //         }
            

    //         if ($user->profile_type == 'admin') {
    //             return view('admin.dashboard', ['user'=>$user,'user'=>$user]);
    //         }else{
    //             return view('auth.profile', ['user' => $user, 'escorts' => $escorts]);
    //         }

    //     }
    //     return redirect()->route('home');
    // }
    /**
 
 * Handle the user's profile view based on their profile type.
 *
 * @return \Illuminate\Http\Response|\Illuminate\Routing\Redirector
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
                              ->where('accepted', false)
                              ->get();

    // Préparer la liste des invitations
    foreach ($invitations as $invitation) {
        $listInvitation[] = [
            'dateNotification' => $invitation->created_at, // Date de création de l'invitation
            'userInvited' => User::find($invitation->invited_id), // Détails de l'utilisateur invité
        ];
    }

    // Afficher une vue basée sur le type de profil de l'utilisateur
    switch ($user->profile_type) {
        case 'salon':
            // Vue pour les utilisateurs de type "salon" avec les invitations
            return view('auth.profile', compact('user', 'escorts', 'listInvitation'));

        case 'admin':
            // Vue pour les administrateurs
            return view('admin.dashboard', compact('user'));

        default:
            // Vue par défaut pour les autres types de profils
            return view('auth.profile', compact('user', 'escorts'));
    }
}


}
