<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Ville;
use App\Models\Categorie;
use App\Models\Service;
use App\Models\User;
use App\Models\Invitation;
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

        if (Auth::check()) {
          // $user = Auth::user()->load('canton');
          $user = Auth::user();
          if ($escort->id == $user->id)
          {
          return redirect()->route('profile.index');
          }else{
            return view('sp_escort', [
              'escort' => $escort,
          ]);
          }
        }
        else
        {
          return view('sp_escort', [
              'escort' => $escort,
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
    // Validation des données entrantes
    $validated = $request->validate([
        'escort_ids' => 'required|array', // `escort_ids` doit être un tableau
        'escort_ids.*' => 'integer|exists:users,id', // Chaque élément du tableau doit être un ID valide d'utilisateur
    ]);

    // Vérification de l'authentification avant toute opération
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour inviter des escorts.');
    }

    // Récupérer l'utilisateur connecté
    $authUser = Auth::user();

    // Récupérer les utilisateurs avec le profile_type "escorte" à partir des IDs validés
    $escorts = User::whereIn('id', $validated['escort_ids'])
                   ->where('profile_type', 'escorte')
                   ->get();

    // Vérifier si tous les IDs correspondent à des escorts
    if ($escorts->count() !== count($validated['escort_ids'])) {
        return redirect()->back()->with('error', 'Certains utilisateurs sélectionnés ne sont pas des escorts.');
    }

    // Envoyer une invitation et une notification à chaque escort
    foreach ($escorts as $escort) {
      // Vérifier si une invitation existe déjà entre inviter_id et invited_id
      $existingInvitation = Invitation::where('inviter_id', $authUser->id)
          ->where('invited_id', $escort->id)
          ->first();
  
      if (!$existingInvitation) {
          // Enregistrer une invitation dans la base de données
          Invitation::create([
              'inviter_id' => $authUser->id, // ID de l'utilisateur qui envoie l'invitation
              'invited_id' => $escort->id,  // ID de l'escort invité
              'accepted' => false,          // Par défaut, l'invitation est en attente
              'type' => 'invite par salon'
          ]);
  
          // Envoyer une notification à l'escort
          $escort->notify(new EscortInvitationNotification($authUser));
      } else {
          // Optionnel : Log ou message indiquant que l'invitation existe déjà
         
      }
  }
  
    return redirect()->route('profile.index')
    ->with('success', 'Votre demande d\'invitation a été envoyée avec succès!');
}

public function accepter($id)
{
    // Vérification de l'authentification avant toute opération
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette action.');
    }

    // Récupérer l'utilisateur connecté
    $authUser = Auth::user();

    // Vérifier si l'utilisateur est de type "escorte"
    if ($authUser->profile_type !== 'escorte') {
        return back()->with('error', 'Seuls les utilisateurs avec un profil "escorte" peuvent accepter des invitations.');
    }

    // Rechercher l'invitation par son ID
    $invitation = Invitation::find($id);

    // Vérifier si l'invitation existe
    if (!$invitation) {
        return back()->with('error', 'Invitation non trouvée.');
    }

    // Marquer l'invitation comme acceptée
    $invitation->accepted = true;
    $invitation->save();

    // Retourner avec un message de succès
    return back()->with('success', 'Invitation acceptée avec succès.');
}


public function refuser($id)
{
    // Vérification de l'authentification avant toute opération
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette action.');
    }

    // Récupérer l'utilisateur connecté
    $authUser = Auth::user();

    // Vérifier si l'utilisateur est de type "escorte"
    if ($authUser->profile_type !== 'escorte') {
        return back()->with('error', 'Seuls les utilisateurs avec un profil "escorte" peuvent accepter des invitations.');
    }

    // Rechercher l'invitation par son ID
    $invitation = Invitation::find($id);

    // Vérifier si l'invitation existe
    if (!$invitation) {
        return back()->with('error', 'Invitation non trouvée.');
    }

    // Marquer l'invitation comme acceptée
    $invitation->accepted = false;
    $invitation->save();

    // Retourner avec un message de succès
    return back()->with('success', 'Invitation refusée avec succès.');
}


public function cancel($id)
{
    // Vérification de l'authentification avant toute opération
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour accéder à cette action.');
    }

    // Récupérer l'utilisateur connecté
    $authUser = Auth::user();

    // Vérifier si l'utilisateur est de type "escorte"
    if ($authUser->profile_type !== 'salon') {
        return back()->with('error', 'Seuls les utilisateurs avec un profil "escorte" peuvent accepter ou gérer des invitations.');
    }

    // Récupérer l'invitation et vérifier son existence
    $invitation = Invitation::find($id);
    if (!$invitation) {
        return back()->with('error', 'Invitation non trouvée.');
    }

    // Supprimer l'invitation
    $invitation->delete();

    return back()->with('success', 'Invitation annulée avec succès.');
}






  
}
