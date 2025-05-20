<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Ville;
use App\Models\Categorie;
use App\Models\Service;
use App\Models\User;
use App\Models\SalonEscorte;
use App\Models\Invitation;
use App\Models\Favorite;
use App\Models\Commentaire;
use Illuminate\Support\Facades\Cache;


use App\Models\Message;



use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Notifications\EscortInvitationNotification;

class EscortController extends Controller
{
    public function show($id)
    {
        $escort = User::find($id);
        $escort['canton'] = Canton::find($escort->canton);
        $escort['ville'] = Ville::find($escort->ville);
      
        $escort['categories'] = Categorie::find($escort->categorie);
        $serviceIds = explode(',', $escort->service);
        $escort['service'] = Service::whereIn('id', $serviceIds)->get();
        // $escort['service'] = Service::find($escort->service);


        $salonAssociers = Invitation::where('invited_id', $escort->id)
        ->where('accepted', true)
        // ->where('type', 'invite par salon')
        ->with(['inviter.cantonget'])
        ->with(['inviter.villeget'])
        ->get();


        if (Auth::check()) {
          // $user = Auth::user()->load('canton');
          $user = Auth::user();
          if ($escort->id == $user->id)
          {
          return redirect()->route('profile.index');
          }else{
            return view('sp_escort', [
              'escort' => $escort,
              'salonAssociers' => $salonAssociers,
          ]);
          }
        }
        else
        {
          return view('sp_escort', [
              'escort' => $escort,
                'salonAssociers' => $salonAssociers,
          ]);
        }

    }

    public function search_escort()
  {
    $categories = Categorie::all();
    $services = Service::all();
    $cantons = Canton::all();
    $villes = Ville::all();
    $escorts = User::where('profile_type', 'escorte')->get();

    foreach ($escorts as $escort) {
      $escort['canton'] = Canton::find($escort->canton);
      $escort['ville'] = Ville::find($escort->ville);
      $escort['categorie'] = Categorie::find($escort->categorie);
      $escort['service'] = Service::find($escort->service);
    }

    return view('search_page_escort', ['cantons'=> $cantons, 'categories'=> $categories, 'escorts' => $escorts]);
  }

    /**
     * Permet à un utilisateur d'inviter des escorts.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function inviterEscorte(Request $request)
    {
        // Vérification de l'authentification avant toute opération
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('escort.errors.login_required'));
        }

        // Validation des données entrantes
        $validated = $request->validate([
            'escort_ids' => 'required|array',
            'escort_ids.*' => 'integer|exists:users,id',
        ], [
            'escort_ids.required' => __('escort.validation.escort_ids_required'),
            'escort_ids.array' => __('escort.validation.escort_ids_array'),
            'escort_ids.*.integer' => __('escort.validation.escort_ids_integer'),
            'escort_ids.*.exists' => __('escort.validation.escort_ids_exists'),
        ]);

        // Récupérer l'utilisateur connecté
        $authUser = Auth::user();

        // Vérifier si des escortes ont été sélectionnées
        if (empty($validated['escort_ids'])) {
            return redirect()->back()->with('error', __('escort.errors.no_escorts_selected'));
        }

        // Récupérer les utilisateurs avec le profile_type "escorte" à partir des IDs validés
        $escorts = User::whereIn('id', $validated['escort_ids'])
                    ->where('profile_type', 'escorte')
                    ->get();

        // Vérifier si tous les IDs correspondent à des escorts
        if ($escorts->count() !== count($validated['escort_ids'])) {
            return redirect()->back()->with('error', __('escort.errors.invalid_escort_type'));
        }

        try {
            // Envoyer une invitation et une notification à chaque escort
            foreach ($escorts as $escort) {
                // Vérifier si une invitation existe déjà entre inviter_id et invited_id
                $existingInvitation = Invitation::where('inviter_id', $authUser->id)
                    ->where('invited_id', $escort->id)
                    ->first();
        
                if (!$existingInvitation) {
                    // Enregistrer une invitation dans la base de données
                    Invitation::create([
                        'inviter_id' => $authUser->id,
                        'invited_id' => $escort->id,
                        'accepted' => false,
                        'type' => 'invite par salon'
                    ]);
        
                    // Envoyer une notification à l'escort
                    $escort->notify(new EscortInvitationNotification($authUser));
                }
            }
            
            return redirect()->route('profile.index')
                ->with('success', __('escort.success.invitation_sent'));
                
        } catch (\Exception $e) {
            \Log::error('Error sending escort invitation: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', __('escort.errors.authentication_failed'))
                ->withInput();
        }
    }

    public function inviterSalon(Request $request)
    {
        // Vérification de l'authentification avant toute opération
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('escort.errors.login_required'));
        }

        // Validation des données entrantes
        $validated = $request->validate([
            'salon_ids' => 'required|array',
            'salon_ids.*' => 'integer|exists:users,id',
        ], [
            'salon_ids.required' => __('escort.validation.escort_ids_required'),
            'salon_ids.array' => __('escort.validation.escort_ids_array'),
            'salon_ids.*.integer' => __('escort.validation.escort_ids_integer'),
            'salon_ids.*.exists' => __('escort.validation.escort_ids_exists'),
        ]);

        // Récupérer l'utilisateur connecté
        $authUser = Auth::user();

        // Vérifier si des salons ont été sélectionnés
        if (empty($validated['salon_ids'])) {
            return redirect()->back()->with('error', __('escort.errors.no_escorts_selected'));
        }

        // Récupérer les utilisateurs avec le profile_type "salon" à partir des IDs validés
        $salons = User::whereIn('id', $validated['salon_ids'])
                    ->where('profile_type', 'salon')
                    ->get();

        // Vérifier si tous les IDs correspondent à des salons
        if ($salons->count() !== count($validated['salon_ids'])) {
            return redirect()->back()->with('error', __('escort.errors.invalid_salon_type'));
        }

        try {
            // Envoyer une invitation et une notification à chaque salon
            foreach ($salons as $salon) {
                // Vérifier si une invitation existe déjà entre inviter_id et invited_id
                $existingInvitation = Invitation::where('invited_id', $authUser->id)
                    ->where('inviter_id', $salon->id)
                    ->first();
        
                if (!$existingInvitation) {
                    // Enregistrer une invitation dans la base de données
                    Invitation::create([
                        'inviter_id' => $authUser->id,
                        'invited_id' => $salon->id,
                        'accepted' => false,
                        'type' => 'associe au salon'
                    ]);
        
                    // Envoyer une notification au salon
                    $salon->notify(new EscortInvitationNotification($authUser));
                }
            }
            
            return redirect()->route('profile.index')
                ->with('success', __('escort.success.invitation_sent'));
                
        } catch (\Exception $e) {
            \Log::error('Error sending salon invitation: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', __('escort.errors.authentication_failed'))
                ->withInput();
        }
    }

    public function accepter($id)
    {
        // Vérification de l'authentification avant toute opération
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('escort.errors.login_required'));
        }

        // Récupérer l'utilisateur connecté
        $authUser = Auth::user();

        // Vérifier si l'utilisateur est de type "escorte" ou "salon"
        if ($authUser->profile_type !== 'escorte' && $authUser->profile_type !== 'salon') {
            return back()->with('error', __('escort.errors.unauthorized'));
        }

        try {
            // Rechercher l'invitation par son ID
            $invitation = Invitation::findOrFail($id);

            // Vérifier si l'utilisateur connecté est bien impliqué dans l'invitation
            if ($invitation->invited_id !== $authUser->id) {
                return back()->with('error', __('escort.errors.unauthorized'));
            }

            // Marquer l'invitation comme acceptée
            $invitation->accepted = true;
            $invitation->save();

            // Créer une association salon-escort si elle n'existe pas déjà
            if ($authUser->profile_type === 'escorte') {
                SalonEscorte::firstOrCreate([
                    'salon_id' => $invitation->inviter_id,
                    'escorte_id' => $authUser->id,
                ]);
            } else if ($authUser->profile_type === 'salon') {
                SalonEscorte::firstOrCreate([
                    'salon_id' => $authUser->id,
                    'escorte_id' => $invitation->inviter_id,
                ]);
            }

            // Retourner avec un message de succès
            return back()->with('success', __('escort.success.invitation_accepted'));
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Invitation not found: ' . $e->getMessage());
            return back()->with('error', __('escort.errors.invitation_not_found'));
            
        } catch (\Exception $e) {
            \Log::error('Error accepting invitation: ' . $e->getMessage());
            return back()->with('error', __('escort.errors.authentication_failed'));
        }
    }


    public function refuser($id)
    {
        // Vérification de l'authentification avant toute opération
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('escort.errors.login_required'));
        }

        // Récupérer l'utilisateur connecté
        $authUser = Auth::user();

        // Vérifier si l'utilisateur est de type "escorte" ou "salon"
        if ($authUser->profile_type !== 'escorte' && $authUser->profile_type !== 'salon') {
            return back()->with('error', __('escort.errors.unauthorized'));
        }

        try {
            // Rechercher l'invitation par son ID
            $invitation = Invitation::findOrFail($id);

            // Vérifier si l'utilisateur connecté est bien impliqué dans l'invitation
            if ($invitation->invited_id !== $authUser->id) {
                return back()->with('error', __('escort.errors.unauthorized'));
            }


            // Marquer l'invitation comme refusée
            $invitation->accepted = false;
            $invitation->save();

            // Retourner avec un message de succès
            return back()->with('success', __('escort.success.invitation_rejected'));
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Invitation not found when refusing: ' . $e->getMessage());
            return back()->with('error', __('escort.errors.invitation_not_found'));
            
        } catch (\Exception $e) {
            \Log::error('Error rejecting invitation: ' . $e->getMessage());
            return back()->with('error', __('escort.errors.authentication_failed'));
        }
    }


    public function cancel($id)
    {
        // Vérification de l'authentification avant toute opération
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('escort.errors.login_required'));
        }

        // Récupérer l'utilisateur connecté
        $authUser = Auth::user();

        // Vérifier si l'utilisateur est de type "salon" ou "escorte"
        if ($authUser->profile_type !== 'salon' && $authUser->profile_type !== 'escorte') {
            return back()->with('error', __('escort.errors.unauthorized'));
        }

        try {
            // Récupérer l'invitation et vérifier son existence
            $invitation = Invitation::findOrFail($id);
            
            // Vérifier que l'utilisateur connecté est bien l'émetteur de l'invitation
            if ($invitation->inviter_id !== $authUser->id) {
                return back()->with('error', __('escort.errors.unauthorized'));
            }

            // Supprimer l'invitation
            $invitation->delete();

            return back()->with('success', __('escort.success.invitation_cancelled'));
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Invitation not found when cancelling: ' . $e->getMessage());
            return back()->with('error', __('escort.errors.invitation_not_found'));
            
        } catch (\Exception $e) {
            \Log::error('Error cancelling invitation: ' . $e->getMessage());
            return back()->with('error', __('escort.errors.authentication_failed'));
        }
    }




    public function gererEscorte(Request $request, $id)
    {
        // Vérification de l'authentification avant toute opération
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('escort.errors.login_required'));
        }

        // Récupérer l'utilisateur connecté
        $userConnected = Auth::user();

        // Vérifier si l'utilisateur connecté est un salon
        if ($userConnected->profile_type !== 'salon') {
            return redirect()->back()->with('error', __('escort.errors.unauthorized'));
        }

        try {
            // Récupérer l'escorte associée
            $salonEscorte = SalonEscorte::where('escorte_id', $id)
                                        ->where('salon_id', $userConnected->id)
                                        ->firstOrFail();

            // Enregistrer le dernier timestamp avant déconnexion
            $user = Auth::user();
            $user->last_seen_at = now();
            $user->save();

            // Supprimer le cache de l'utilisateur
            Cache::forget('user-is-online-' . $user->id);

            // Déconnexion de l'utilisateur actuel
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Récupérer le userEscorte
            $userEscorte = User::findOrFail($id);

            // Connexion du userEscorte
            if (Auth::loginUsingId($userEscorte->id)) {
                $request->session()->regenerate();
                return redirect()->route('profile.index')
                    ->with('success',  __('escort.success.escort_managed', ['name' => $userEscorte->prenom]));
            }

            return redirect()->route('login')->with('error', __('escort.errors.authentication_failed'));
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Escort not found for salon: ' . $e->getMessage());
            return redirect()->back()->with('error', __('escort.errors.escort_not_found'));
            
        } catch (\Exception $e) {
            \Log::error('Error managing escort: ' . $e->getMessage());
            return redirect()->back()->with('error', __('escort.errors.authentication_failed'));
        }
    }


    public function revenirSalon(Request $request, $id)
    {
        // Vérification de l'authentification avant toute opération
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('escort.errors.login_required'));
        }

        // Récupérer l'utilisateur connecté
        $userConnected = Auth::user();

        // Vérifier si l'utilisateur connecté est une escorte
        if ($userConnected->profile_type !== 'escorte') {
            return redirect()->back()->with('error', __('escort.errors.unauthorized'));
        }

        try {
            // Récupérer le salon associé
            $salonEscorte = SalonEscorte::where('salon_id', $id)
                                        ->where('escorte_id', $userConnected->id)
                                        ->firstOrFail();

            // Enregistrer le dernier timestamp avant déconnexion
            $userConnected->last_seen_at = now();
            $userConnected->save();

            // Supprimer le cache de l'utilisateur
            Cache::forget('user-is-online-' . $userConnected->id);


            // Récupérer le salon avant la déconnexion
            $userSalon = User::findOrFail($salonEscorte->salon_id);

            // Déconnexion de l'utilisateur actuel
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Connexion au salon
            if (Auth::loginUsingId($userSalon->id)) {
                $request->session()->regenerate();
                return redirect()->route('profile.index')
                    ->with('success', __('escort.success.returned_to_salon', ['name' => $userSalon->nom_salon]));
            }

            return redirect()->route('login')->with('error', __('escort.errors.authentication_failed'));
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Salon not found for escort: ' . $e->getMessage());
            return redirect()->back()->with('error', __('escort.errors.salon_not_found'));
            
        } catch (\Exception $e) {
            \Log::error('Error returning to salon: ' . $e->getMessage());
            return redirect()->back()->with('error', __('escort.errors.authentication_failed'));
        }
    }

    public function deleteEscorteCreateBySalon($id)
    {
        // Vérification de l'authentification avant toute opération
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('escort.errors.login_required'));
        }

        // Récupérer l'utilisateur connecté
        $userConnected = Auth::user();

        // Vérifier si l'utilisateur connecté est un salon
        if ($userConnected->profile_type !== 'salon') {
            return redirect()->back()->with('error', __('escort.errors.unauthorized'));
        }

        try {
            // Récupérer l'escorte associée
            $salonEscorte = SalonEscorte::where('escorte_id', $id)
                                        ->where('salon_id', $userConnected->id)
                                        ->firstOrFail();

            // Récupérer l'utilisateur de l'escorte
            $escortUser = User::findOrFail($id);

            // Vérifier que l'utilisateur est bien une escorte
            if ($escortUser->profile_type !== 'escorte') {
                return redirect()->back()->with('error', __('escort.errors.unauthorized'));
            }

            // Récupérer l'invitation existante
            $existingInvitation = Invitation::where('inviter_id', $userConnected->id)
                                            ->where('invited_id', $id)
                                            ->where('type', 'creer par salon')
                                            ->firstOrFail();

            // Supprimer l'invitation
            $existingInvitation->delete();
            
            // Supprimer l'association salon-escorte
            $salonEscorte->delete();

            // Supprimer l'utilisateur de l'escorte
            $escortUser->delete();

            // Rediriger avec un message de succès
            return redirect()->route('profile.index')
                ->with('success', __('escort.success.escort_deleted'));
                
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Escort or association not found when deleting: ' . $e->getMessage());
            return redirect()->back()->with('error', __('escort.errors.escort_not_found'));
            
        } catch (\Exception $e) {
            \Log::error('Error deleting escort: ' . $e->getMessage());
            return redirect()->back()->with('error', __('escort.errors.authentication_failed'));
        }
    }

    public function autonomiser($id)
    {
        // Vérification de l'authentification avant toute opération
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('escort.errors.login_required'));
        }

        // Récupérer l'utilisateur connecté
        $userConnected = Auth::user();

        // Vérifier si l'utilisateur connecté est un salon
        if ($userConnected->profile_type !== 'salon') {
            return redirect()->back()->with('error', __('escort.errors.unauthorized'));
        }

        try {
            // Récupérer l'escorte associée
            $salonEscorte = SalonEscorte::where('escorte_id', $id)
                                        ->where('salon_id', $userConnected->id)
                                        ->firstOrFail();

            // Récupérer l'utilisateur de l'escorte
            $escortUser = User::findOrFail($id);

            // Vérifier que l'utilisateur est bien une escorte
            if ($escortUser->profile_type !== 'escorte') {
                return redirect()->back()->with('error', __('escort.errors.unauthorized'));
            }


            // Récupérer l'invitation existante
            $existingInvitation = Invitation::where('inviter_id', $userConnected->id)
                                            ->where('invited_id', $id)
                                            ->where('type', 'creer par salon')
                                            ->firstOrFail();

            // Mettre à jour le type d'invitation
            $existingInvitation->type = 'autonome';
            $existingInvitation->save();

            // Rediriger avec un message de succès
            return redirect()->route('profile.index')
                ->with('success', __('escort.success.escort_made_autonomous'));
                
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Escort or association not found when making autonomous: ' . $e->getMessage());
            return redirect()->back()->with('error', __('escort.errors.escort_not_found'));
            
        } catch (\Exception $e) {
            \Log::error('Error making escort autonomous: ' . $e->getMessage());
            return redirect()->back()->with('error', __('escort.errors.authentication_failed'));
        }
    }

}
