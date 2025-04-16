<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Notification;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index()
    {

      // Récupérer l'utilisateur actuellement authentifié
    $user = Auth::user();

    // Récupérer les notifications paginées directement depuis la base de données
    $notifications = Notification::where('notifiable_id', $user->id)
        ->where('type', 'App\Notifications\ProfileVerificationRequestNotification')
        ->orderBy('created_at', 'desc')
        ->paginate(4); // Pagination automatique ici

    // Récupérer les user_id uniques dans les données de notification
    $userIds = $notifications->getCollection()->pluck('data.user_id')->filter()->unique();

    // Charger tous les utilisateurs concernés en une seule requête
    $users = User::whereIn('id', $userIds)->get()->keyBy('id');

    // Formater les notifications
    $formattedNotifications = $notifications->getCollection()->map(function ($notification) use ($users) {
        return [
            'id'=>$notification->id,
            'data' => $notification->data ?? null,
            'user' => isset($notification->data['user_id']) ? $users->get($notification->data['user_id']) : null,
            'created_at' => $notification->created_at->toDateTimeString(),
            'read_at' => $notification->read_at ? $notification->read_at->toDateTimeString() : null,
        ];
    });

    // Remplacer la collection originale par la version formatée
    $notifications->setCollection($formattedNotifications);

    return view('admin.users.index', [
        'users' => User::with('roles')->paginate(10),
        'roles' => Role::all(),
        'demandes' => $notifications, // Notifications paginées et formatées
    ]);
    }

    public function create()
    {
        return view('admin.users.create', [
            'roles' => Role::all()
        ]);
    }

    /**
     * Crée un nouvel utilisateur.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            // Validation des données avec gestion des erreurs personnalisées
            $validatedData = $request->validate([
                'pseudo' => 'required|string|max:255',
                'profile_type' => 'required|in:invite,escorte,salon,admin',
                'date_naissance' =>'required|date|before:' . now()->subYears(18)->toDateString(),
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'roles' => 'sometimes|array',
                'roles.*' => 'exists:roles,id'
            ], [
                'email.unique' => 'Cet email est déjà utilisé',
                'password.confirmed' => 'Les mots de passe ne correspondent pas',
                'roles.*.exists' => 'Un ou plusieurs rôles sélectionnés sont invalides',
            ]);

            // Début transaction pour intégrité des données
            DB::beginTransaction();

            // Création de l'utilisateur
            $user = User::create([
                'profile_type' => $validatedData['profile_type'],
                'date_naissance' => $validatedData['date_naissance'],
                'pseudo' => $validatedData['pseudo'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            // Attribution des rôles avec vérification supplémentaire
            if (isset($validatedData['roles'])) {
                $user->roles()->sync($validatedData['roles']);
            }

            DB::commit();

            // Redirection avec message de succès
            return redirect()->route('users.index')
                ->with('success', 'Utilisateur créé avec succès');

        } catch (ValidationException $e) {
            // Gestion spécifique des erreurs de validation
            return redirect()->back()
                ->withErrors($e->errors())
                ->with('error', $e->getMessage())
                ->withInput();

        } catch (QueryException $e) {
            // Gestion des erreurs de base de données
            DB::rollBack();
            Log::error('Erreur base de données : ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Une erreur base de données est survenue' . $e->getMessage())
                ->withInput();

        } catch (Exception $e) {
            // Gestion des autres exceptions
            DB::rollBack();
            Log::error('Erreur inattendue : ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Une erreur inattendue est survenue')
                ->withInput();
        }
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user->load('roles'),
            'roles' => Role::all()
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'pseudo' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'roles' => 'sometimes|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $user->update([
            'pseudo' => $request->pseudo,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function destroy(User $user)
    {
        // Empêche la suppression de l'admin principal
        if ($user->id === 1) {
            return back()->with('error', 'Impossible de supprimer l\'administrateur principal');
        }

        $user->delete();
        
        return redirect()->route('users.index')
            ->with('success', 'Utilisateur supprimé avec succès');
    }



    public function showDemande($iduser, $idnotif)
    {
        $user = Auth::user();

        // Vérification de l'authentification avant toute opération
        if (!$user || $user->profile_type !== 'admin') {
            return redirect()->route('login')->with('error', "Vous devez être connecté en tant qu'administrateur pour inviter des escorts.");
        }
        
        // Chercher la notification par ID
        $notification = Notification::findOrFail($idnotif);

        // Mettre à jour la colonne read_at avec l'heure actuelle
        $notification->update([
            'read_at' => now(),
        ]);

        $user = User::findOrFail($iduser);
 
        return view('admin.users.demande', [ 
            'user' => $user,
            'idnotif' => $idnotif
        ]);
    }

    
    public function approvedProfile($iduser)
    {

        $user = Auth::user();

        // Vérification de l'authentification avant toute opération
        if (!$user || $user->profile_type !== 'admin') {
            return redirect()->route('login')->with('error', "Vous devez être connecté en tant qu'administrateur pour inviter des escorts.");
        }

        $user = User::findOrFail($iduser);
        $user->update([
            'profile_verifie'=>  'verifier'
        ]);

        return redirect()->route('users.index')
        ->with('success', "Profil de l'utilisateur approuvé avec succès.");
    
    }

     
    public function notApprovedProfile($iduser)
    {

        $user = Auth::user();

        // Vérification de l'authentification avant toute opération
        if (!$user || $user->profile_type !== 'admin') {
            return redirect()->route('login')->with('error', "Vous devez être connecté en tant qu'administrateur pour inviter des escorts.");
        }

        $user = User::findOrFail($iduser);
        $user->update([
            'profile_verifie'=>  'non verifier'
        ]);

        return redirect()->route('users.index')
        ->with('success', "Profil de l'utilisateur n'est pas approuvé avec succès.");
    
    }

}