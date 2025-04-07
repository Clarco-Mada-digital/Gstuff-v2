<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::with('roles')->paginate(10),
            'roles' => Role::all()
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
}