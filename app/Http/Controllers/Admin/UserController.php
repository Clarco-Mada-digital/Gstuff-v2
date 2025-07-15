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

        // Récupérer les notifications paginées avec un nom de paramètre personnalisé
        $notifications = Notification::where('notifiable_id', $user->id)
            ->where('type', 'App\\Notifications\\ProfileVerificationRequestNotification')
            ->orderBy('created_at', 'desc')
            ->paginate(4, ['*'], 'notifications_page');

        // Récupérer les utilisateurs liés aux notifications en une seule requête
        $userIds = $notifications->getCollection()
            ->pluck('data.user_id')
            ->filter()
            ->unique()
            ->values();

        $users = $userIds->isNotEmpty() 
            ? User::whereIn('id', $userIds)->get()->keyBy('id')
            : collect();

        // Formater les notifications
        $formattedNotifications = $notifications->getCollection()->map(function ($notification) use ($users) {
            $userId = $notification->data['user_id'] ?? null;
            
            return [
                'id' => $notification->id,
                'data' => $notification->data ?? null,
                'user' => $userId ? $users->get($userId) : null,
                'created_at' => $notification->created_at->toDateTimeString(),
                'read_at' => $notification->read_at?->toDateTimeString(),
            ];
        });

        $notifications->setCollection($formattedNotifications);

        // Récupérer les utilisateurs avec leurs rôles (pagination séparée)
        $usersPaginated = User::with('roles')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'users_page');

        return view('admin.users.index', [
            'users' => $usersPaginated,
            'roles' => Role::all(),
            'demandes' => $notifications,
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
        $validatedData = $request->validate([
            'pseudo' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,'.$user->id,
            ],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'roles' => 'sometimes|array',
            'roles.*' => 'exists:roles,id'
        ], [
            'pseudo.required' => __('validation.required', ['attribute' => 'pseudo']),
            'pseudo.string' => __('validation.string', ['attribute' => 'pseudo']),
            'pseudo.max' => __('validation.max.string', ['attribute' => 'pseudo', 'max' => 255]),
            'email.required' => __('validation.required', ['attribute' => 'email']),
            'email.string' => __('validation.string', ['attribute' => 'email']),
            'email.email' => __('validation.email', ['attribute' => 'email']),
            'email.max' => __('validation.max.string', ['attribute' => 'email', 'max' => 255]),
            'email.unique' => __('validation.unique', ['attribute' => 'email']),
            'password.confirmed' => __('validation.confirmed', ['attribute' => 'mot de passe']),
            'roles.array' => __('validation.array', ['attribute' => 'rôles']),
            'roles.*.exists' => __('validation.exists', ['attribute' => 'rôle']),
        ]);

        $user->update([
            'pseudo' => $validatedData['pseudo'],
            'email' => $validatedData['email'],
            'password' => isset($validatedData['password']) ? Hash::make($validatedData['password']) : $user->password,
        ]);

        if (isset($validatedData['roles'])) {
            $user->roles()->sync($validatedData['roles']);
        }

        return redirect()->route('users.index')
            ->with('success', __('users.update_success'));
    }

    public function destroy(User $user)
    {
        // Empêche la suppression de l'admin principal
        if ($user->id === 1) {
            return back()->with('error', __('users.cannot_delete_admin'));
        }

        // Delete associated stories first
        $user->stories()->delete();
        
        $user->delete();
        
        return redirect()->route('users.index')
            ->with('success', __('users.delete_success'));
    }



    public function showDemande($iduser)
    {
        $user = Auth::user();

        // Vérification de l'authentification avant toute opération
        if (!$user || $user->profile_type !== 'admin') {
            return redirect()->route('login')->with('error', __('users.admin_required'));
        }

        $iduser = (int) $iduser;

        // Validation de l'entrée
        if (!is_numeric($iduser)) {
            $iduserType = gettype($iduser);
            return redirect()->route('users.index')
                ->with('error', __('users.invalid_user_id', ['type' => $iduserType]));
        }
    
        // Utilisation d'une transaction pour garantir l'atomicité des opérations
        DB::transaction(function () use ($iduser) {
            // Marquer les notifications comme lues
            $notifications = Notification::whereJsonContains('data->user_id', $iduser)
                ->where('type', 'App\\Notifications\\ProfileVerificationRequestNotification')
                ->get();
    
            foreach ($notifications as $notification) {
                $notification->update([
                    'read_at' => now(),
                ]);
            }
        });

        $user = User::findOrFail($iduser);
 
        return view('admin.users.demande', [
            'user' => $user,
        ]);
    }

    
    public function approvedProfile($iduser)
    {
        $user = Auth::user();

        // Vérification de l'authentification avant toute opération
        if (!$user || $user->profile_type !== 'admin') {
            return redirect()->route('login')->with('error', __('users.admin_required'));
        }

        $user = User::findOrFail($iduser);
        $user->update([
            'profile_verifie' => 'verifier'
        ]);

        return redirect()->route('users.index')
            ->with('success', __('users.profile_approved'));
    }

    public function notApprovedProfile($iduser)
    {
        $user = Auth::user();

        // Vérification de l'authentification avant toute opération
        if (!$user || $user->profile_type !== 'admin') {
            return redirect()->route('login')->with('error', __('users.admin_required'));
        }

        $user = User::findOrFail($iduser);
        $user->update([
            'profile_verifie' => 'non verifier'
        ]);

        return redirect()->route('users.index')
            ->with('success', __('users.profile_not_approved'));
    }

    
    public function newUsersCount()
{
    $user = Auth::user();

    // Compter le nombre de notifications non lues
    $newUsersCount = Notification::where('notifiable_id', $user->id)
        ->where('type', 'App\Notifications\ProfileVerificationRequestNotification')
        ->whereNull('read_at')
        ->count();

    // Retourner une réponse JSON avec le nombre de notifications non lues
    return response()->json(['count' => $newUsersCount]);
}

}