<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{


public function index()
{
    // Vérification des permissions
    $this->authorize('manage roles');

    // Récupération des rôles et des permissions
    $roles = Role::with('permissions')->get();
    $permissions = Permission::all();

    // Récupération des utilisateurs selon leur type de profil
    $usersEscortes = User::where('profile_type', 'escorte')->get();
    $usersSalons = User::where('profile_type', 'salon')->get();
    $usersInvites = User::where('profile_type', 'invite')->get();
    $usersEscorteEnCoursVerification = User::where('profile_verifie', 'en cours')
        ->where('profile_type', 'escorte')
        ->get();

    // Récupération des notifications avec les utilisateurs associés
    $notifications = Notification::with('notifiable')->get();

    // Filtrer et structurer les notifications avec les utilisateurs liés
    $notificationsWithUsers = $notifications->filter(function ($notification) {
        return isset($notification->data['user_id']) && !empty($notification->data['user_id']);
    })->map(function ($notification) {
        return [
            'notification' => $notification, // Ajout de l'objet notification complet
            'user' => User::find($notification->data['user_id'])
        ];
    })->values(); // Réindexation pour une liste propre

    // Retourner la vue avec toutes les données compactées
    return view('admin.users.index', compact(
        'roles', 
        'permissions', 
        'usersEscortes', 
        'usersSalons', 
        'usersInvites',
        'usersEscorteEnCoursVerification',
        'notificationsWithUsers' // Liste formatée des notifications avec utilisateurs
    ));
}


    
    
    

   // Enregistrer un nouvel utilisateur dans la base de données
   public function store(Request $request)
    {
        // Liste des règles de validation
        $rules = [
            'pseudo' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'date_naissance' => 'required|date',
            'profile_type' => 'required|in:invite,escorte,salon,admin',
            'intitule' => 'nullable|string|max:255',
            'nom_proprietaire' => 'nullable|string|max:255',
            'user_name' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'npa' => 'nullable|string|max:10',
            'canton' => 'nullable|numeric',
            'ville' => 'nullable',
            'categorie' => 'nullable',
            'service' => 'nullable',
            'oriantation_sexuelles' => 'nullable|string|max:255',
            'recrutement' => 'nullable|string|max:255',
            'nombre_filles' => 'nullable|string|max:255',
            'pratique_sexuelles' => 'nullable|string|max:255',
            'tailles' => 'nullable|string|max:255',
            'origine' => 'nullable|string|max:255',
            'couleur_yeux' => 'nullable|string|max:255',
            'couleur_cheveux' => 'nullable|string|max:255',
            'mensuration' => 'nullable|string|max:255',
            'poitrine' => 'nullable|string|max:255',
            'taille_poitrine' => 'nullable|string|max:255',
            'pubis' => 'nullable|string|max:255',
            'tatouages' => 'nullable|string|max:255',
            'mobilite' => 'nullable|string|max:255',
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
        ];

        // Messages de validation personnalisés
        $messages = [
            'pseudo.required' => __('user.validation.pseudo_required'),
            'pseudo.string' => __('user.validation.pseudo_string'),
            'pseudo.max' => __('user.validation.pseudo_max'),
            'prenom.required' => __('user.validation.prenom_required'),
            'prenom.string' => __('user.validation.prenom_string'),
            'prenom.max' => __('user.validation.prenom_max'),
            'email.required' => __('user.validation.email_required'),
            'email.email' => __('user.validation.email_email'),
            'email.unique' => __('user.validation.email_unique'),
            'password.required' => __('user.validation.password_required'),
            'password.string' => __('user.validation.password_string'),
            'password.min' => __('user.validation.password_min'),
            'date_naissance.required' => __('user.validation.date_naissance_required'),
            'date_naissance.date' => __('user.validation.date_naissance_date'),
            'profile_type.required' => __('user.validation.profile_type_required'),
            'profile_type.in' => __('user.validation.profile_type_in'),
        ];

        // Validation des données entrantes
        $validatedData = $request->validate($rules, $messages);

        // Ajout du mot de passe hashé
        $validatedData['password'] = bcrypt($validatedData['password']);

        // Création de l'utilisateur
        User::create($validatedData);

        // Redirection avec un message de succès
        return redirect()->route('users.index')->with('success', __('user.success.user_created'));
    }

    
    // Afficher le formulaire de modification d'un utilisateur
   
    public function edit($id)
   {
       $user = User::findOrFail($id); // Trouve l'utilisateur par son ID
       return view('admin.users.edit', compact('user')); // Charge la vue pour éditer un utilisateur
   }

   // Mettre à jour les informations d'un utilisateur
   public function update(Request $request, $id)
   {
       // Règles de validation
       $rules = [
           'pseudo' => 'required|string|max:255',
           'prenom' => 'required|string|max:255',
           'email' => 'required|email|unique:users,email,' . $id,
           'date_naissance' => 'nullable|date',
           'profile_type' => 'required|in:invite,escorte,salon,admin',
       ];

       // Messages de validation personnalisés
       $messages = [
           'pseudo.required' => __('user.validation.pseudo_required'),
           'pseudo.string' => __('user.validation.pseudo_string'),
           'pseudo.max' => __('user.validation.pseudo_max'),
           'prenom.required' => __('user.validation.prenom_required'),
           'prenom.string' => __('user.validation.prenom_string'),
           'prenom.max' => __('user.validation.prenom_max'),
           'email.required' => __('user.validation.email_required'),
           'email.email' => __('user.validation.email_email'),
           'email.unique' => __('user.validation.email_unique'),
           'date_naissance.date' => __('user.validation.date_naissance_date'),
           'profile_type.required' => __('user.validation.profile_type_required'),
           'profile_type.in' => __('user.validation.profile_type_in'),
       ];

       // Validation des données
       $validatedData = $request->validate($rules, $messages);

       // Trouve l'utilisateur et met à jour les données
       $user = User::findOrFail($id);
       $user->update($validatedData);

       // Redirection avec un message de succès
       return redirect()->route('users.index')->with('success', __('user.success.user_updated'));
   }

   // Supprimer un utilisateur
   public function destroy($id)
   {
       $user = User::findOrFail($id); // Trouve l'utilisateur par son ID
       $user->delete(); // Supprime l'utilisateur

       // Redirection avec un message de succès
       return redirect()->route('users.index')->with('success', __('user.success.user_deleted'));
   }
}
